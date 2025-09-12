<?php

namespace App\Models;

use App\Enums\AlbumTypeEnum;
use App\Helpers\FileExtensionFromString;
use App\Models\Abstract\AbstractModel;
use DB;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class Artist extends AbstractModel implements HasMedia
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait, InteractsWithMedia, Searchable;

    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
    }

    public function searchableAs(): string
    {
        return 'artists_index';
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'album_titles' => $this->albums->pluck('title')->toArray(),
            'created_at' => $this->created_at->timestamp,
        ];
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('artist-backgrounds')->useDisk('artist_images')->singleFile();
    }

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->height(2560)
            ->quality(90)
            ->format('webp')
            ->nonQueued();

        $this
            ->addMediaConversion('preview')
            ->width(400)
            ->quality(80)
            ->format('webp')
            ->nonQueued();

        $this
            ->addMediaConversion('placeholder')
            ->width(400)
            ->blur(50)
            ->quality(75)
            ->format('jpeg')
            ->nonQueued();
    }

    public function attachBackgroundImage(string $string): void
    {
        $fileExtension = new FileExtensionFromString;
        $randomString = Str::random();

        $this
            ->addMedia($string)
            ->preservingOriginal()
            ->setName("$this->slug-background")
            ->setFileName("$this->slug-$randomString-background.{$fileExtension($string)}")
            ->toMediaCollection('artist-backgrounds');
    }

    public function detachBackgroundImage(): void
    {
        $this->clearMediaCollection('artist-backgrounds');
    }

    protected function backgroundImage(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('artist-backgrounds', 'thumb'),
        );
    }

    protected function backgroundImagePreview(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->getFirstMediaUrl('artist-backgrounds', 'preview'),
        );
    }

    protected function backgroundImagePlaceholder(): Attribute
    {
        return Attribute::make(
            get: fn() => 'data:image/jpeg;base64,' . base64_encode(file_get_contents($this->getFirstMediaPath('artist-backgrounds', 'placeholder'))),
        );
    }

    public function cleanName(): Attribute
    {
        // If &nbsp; is present, replace it with a non-breaking space
        return Attribute::make(
            get: fn() => str_replace('&nbsp;', ' ', $this->attributes['name']),
        );
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }

    /**
     * Get album counts by type for this artist, sorted by enum order
     */
    public function getAlbumTypeCounts(): array
    {
        $typesCount = $this->albums()
            ->select('type', DB::raw('count(*) as count'))
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
        $typesCount['All'] = array_sum($typesCount);

        $sortOrder = AlbumTypeEnum::getSortOrder();
        uksort($typesCount, function ($a, $b) use ($sortOrder) {
            if ($a === 'All') return -1;
            if ($b === 'All') return 1;
            $orderA = $sortOrder[$a] ?? 999;
            $orderB = $sortOrder[$b] ?? 999;
            return $orderA <=> $orderB;
        });

        return $typesCount;
    }
}
