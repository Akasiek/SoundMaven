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

    public function registerMediaConversions(Media|null $media = null): void
    {
        $this
            ->addMediaConversion('thumb')
            ->height(2560)
            ->quality(90)
            ->format('webp')
            ->nonQueued();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('artist-backgrounds')->singleFile();
    }

    public function attachBackgroundImage(string $string): void
    {
        $fileExtensionFromStringHelper = new FileExtensionFromString;

        $this
            ->addMedia($string)
            ->preservingOriginal()
            ->setName("{$this->slug}-background")
            ->setFileName("{$this->slug}-background.{$fileExtensionFromStringHelper($string)}")
            ->toMediaCollection('artist-backgrounds');
    }

    public function detachBackgroundImage(): void
    {
        $this->clearMediaCollection('artist-backgrounds');
    }

    protected function backgroundImage(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->getFirstMediaUrl('artist-backgrounds', 'thumb'),
        );
    }

    public function albums(): HasMany
    {
        return $this->hasMany(Album::class);
    }
}
