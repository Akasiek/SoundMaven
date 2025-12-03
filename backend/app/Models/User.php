<?php

namespace App\Models;

use App\Enums\UserRolesEnum;
use App\Helpers\FileExtensionFromString;
use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
    use HasFactory, HasUuids, InteractsWithMedia, Notifiable, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'favorite_artist_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRolesEnum::class,
    ];

    protected $attributes = [
        'role' => UserRolesEnum::USER,
    ];

    public function sluggable(): array
    {
        return ['slug' => [
            'source' => 'name',
            'method' => static function(string $string, string $separator): string {
                return new Slugify(['separator' => $separator])->slugify($string) ?: 'unnamed';
            },
        ]];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('user-avatars')->useDisk('user_images')->singleFile();
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(256)
            ->height(256)
            ->quality(90)
            ->format('webp')
            ->nonQueued();

        $this
            ->addMediaConversion('preview')
            ->width(64)
            ->height(64)
            ->quality(80)
            ->format('webp')
            ->nonQueued();
    }

    public function attachAvatar(string $string): void
    {
        $fileExtension = new FileExtensionFromString;
        $randomString = Str::random();

        $this
            ->addMedia($string)
            ->preservingOriginal()
            ->setName("$this->slug-cover")
            ->setFileName("$this->slug-$randomString-cover.{$fileExtension($string)}")
            ->toMediaCollection('user-avatars');
    }

    public function detachAvatar(): void
    {
        $this->clearMediaCollection('user-avatars');
    }

    protected function avatar(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('user-avatars', 'thumb'),
        );
    }

    protected function avatarPreview(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('user-avatars', 'preview'),
        );
    }

    public function albumRatingCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->albumReviews()->count()
        );
    }

    public function albumReviewCount(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->albumReviews()->whereNotNull('body')->count()
        );
    }

    public function averageAlbumRating(): Attribute
    {
        return Attribute::make(
            get: fn() => round($this->albumReviews()->whereNotNull('rating')->avg('rating'), 2)
        );
    }

    public function isAdmin(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->role === UserRolesEnum::ADMIN
        );
    }

    public function isMaintainer(): Attribute
    {
        return Attribute::make(
            get: fn() => in_array($this->role, [UserRolesEnum::MAINTAINER, UserRolesEnum::ADMIN])
        );
    }

    public function albumReviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class, 'created_by');
    }

    public function favoriteArtist(): BelongsTo
    {
        return $this->belongsTo(Artist::class, 'favorite_artist_id');
    }
}
