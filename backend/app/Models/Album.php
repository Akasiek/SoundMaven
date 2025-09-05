<?php

namespace App\Models;

use App\Enums\AlbumTypeEnum;
use App\Helpers\FileExtensionFromString;
use App\Helpers\SecondsToTime;
use App\Models\Abstract\AbstractModel;
use Cocur\Slugify\Slugify;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class Album extends AbstractModel implements HasMedia
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait, InteractsWithMedia, Searchable;

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

    protected $casts = [
        'type' => AlbumTypeEnum::class,
    ];

    public function sluggable(): array
    {
        return ['slug' => [
            'source' => 'title',
            'method' => static function (string $string, string $separator): string {
                return new Slugify(['separator' => $separator])->slugify($string) ?: 'untitled';
            }
        ]];
    }

    public function searchableAs(): string
    {
        return 'albums_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'artist_name' => $this->artist->name,
            'track_titles' => $this->tracks->pluck('title')->toArray(),
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('album-covers')->useDisk('album_images')->singleFile();
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

        $this
            ->addMediaConversion('preview')
            ->width(500)
            ->height(500)
            ->quality(80)
            ->format('webp')
            ->nonQueued();
    }

    public function attachCoverImage(string $string): void
    {
        $fileExtension = new FileExtensionFromString;
        $randomString = Str::random();

        $this
            ->addMedia($string)
            ->preservingOriginal()
            ->setName("$this->slug-cover")
            ->setFileName("$this->slug-$randomString-cover.{$fileExtension($string)}")
            ->toMediaCollection('album-covers');
    }

    public function detachCoverImage(): void
    {
        $this->clearMediaCollection('album-covers');
    }

    protected function coverImage(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('album-covers', 'thumb'),
        );
    }

    protected function coverImagePreview(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('album-covers', 'preview'),
        );
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

    public function currentUserReview(): HasOne
    {
        return $this->hasOne(AlbumReview::class)->where('created_by', auth()->id());
    }

    public function averageRating(): Attribute
    {
        return Attribute::make(
            get: fn() => (int)$this->reviews()->avg('rating') ?: "Ø",
        );
    }

    /**
     * Get the TailwindCSS class for the rating color based on the average rating.
     *
     * This method calculates the average rating of the album and returns a CSS class
     * that represents the color associated with the rating range.
     *
     * @return Attribute
     */
    public function ratingColor(): Attribute
    {
        $avg = $this->averageRating;

        if ($avg === 'Ø') {
            $color = 'text-gray-400';
        } elseif ($avg < 30) {
            $color = 'text-red-400';
        } elseif ($avg < 70) {
            $color = 'text-yellow-400';
        } else {
            $color = 'text-green-400';
        }

        return Attribute::make(
            get: fn() => $color,
        );
    }

    public function totalLength(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getTotalLength(),
        );
    }

    public function totalLengthFormatted(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getTotalLength(true),
        );
    }

    private function getTotalLength(bool $formatted = false): mixed
    {
        $totalLength = $this->tracks->sum('length');
        return $formatted ? new SecondsToTime()->convert($totalLength) : $totalLength;
    }
}
