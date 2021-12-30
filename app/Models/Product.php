<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = ['name', 'price'];

    protected $appends = ['images'];

    protected $hidden = ['media'];

    public function transactions()
    {
        return $this->hasMany(Product::class);
    }

    public function getImagesAttribute()
    {
        $medias = $this->getMedia('product-cols')->first();
        if ($medias) {
            $images['large'] = $medias->getUrl('large');
            $images['medium'] = $medias->getUrl('medium');
            $images['small'] = $medias->getUrl('small');
        } else {
            $images['large'] = null;
            $images['medium'] = null;
            $images['small'] = null;
        }
        return $images;
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('large')
            ->width(1024)
            ->height(600);

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(400);

        $this->addMediaConversion('small')
            ->width(215)
            ->height(80);
    }
}
