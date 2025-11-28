<?php

namespace App\Models;

use App\Enums\UserRolesEnum;
use Cocur\Slugify\Slugify;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, Sluggable, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    public function albumReviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class, 'created_by');
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
}
