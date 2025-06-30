<?php

namespace App\Models;

use App\Helpers\FileExtensionFromString;
use App\Models\Abstract\AbstractModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use RichanFongdasen\EloquentBlameable\BlameableTrait;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class Artist extends AbstractModel implements HasMedia
{
    use SoftDeletes, HasFactory, HasUuids, BlameableTrait, InteractsWithMedia;

    protected $fillable = [
        'name',
        'description',
        'type',
    ];

    public function sluggable(): array
    {
        return ['slug' => ['source' => 'name']];
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
            ->width(300)
            ->quality(80)
            ->format('webp')
            ->nonQueued();
    }

    public function attachBackgroundImage(string $string): void
    {
        $fileExtensionFromStringHelper = new FileExtensionFromString;

        $randomString = Str::random();

        $this
            ->addMedia($string)
            ->preservingOriginal()
            ->setName("$this->slug-background")
            ->setFileName("$this->slug-$randomString-background.{$fileExtensionFromStringHelper($string)}")
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
}
