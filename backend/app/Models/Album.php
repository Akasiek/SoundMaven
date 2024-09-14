<?php

namespace App\Models;

use App\Helpers\FileExtensionFromString;
use App\Models\Abstract\AbstractModel;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Album extends AbstractModel implements HasMedia
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'release_date',
        'type',
        'artist_id',
    ];

    protected $attributes = [
        'type' => 'LP',
    ];

    public function sluggable(): array
    {
        return ['slug' => [
            'source' => 'title',
            'method' => static function (string $string, string $separator): string {
                return (new Slugify(['separator' => $separator]))->slugify($string) ?: 'untitled';
            }
        ]];
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->width(1000)
            ->height(1000)
            ->quality(90)
            ->format('webp')
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('album-covers')->singleFile();
    }

    public function attachCoverImage(string $string): void
    {
        $fileExtensionFromStringHelper = new FileExtensionFromString;

        $this
            ->addMedia($string)
            ->preservingOriginal()
            ->setName("{$this->slug}-cover")
            ->setFileName("{$this->slug}-cover.{$fileExtensionFromStringHelper($string)}")
            ->toMediaCollection('album-covers');
    }

    public function detachCoverImage(): void
    {
        $this->getFirstMedia('album-covers')?->delete();
    }

    public function artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(AlbumTag::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(AlbumReview::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(Track::class);
    }

    public function averageRating(): float
    {
        return $this->reviews()->avg('rating');
    }
}
