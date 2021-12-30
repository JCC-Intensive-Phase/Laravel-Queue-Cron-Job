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

    protected $fillable = [
        'name',
        'price',
        'stock'
    ];

    protected $appends = [
        'image'
    ];

    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class);
    // }

    public function getImageUrlAttribute()
    {
        $medias = $this->getMedia('products')->first();
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
            ->height(600)
            ->useDisk('s3');

        $this->addMediaConversion('medium')
            ->width(800)
            ->height(400)
            ->useDisk('s3');

        $this->addMediaConversion('small')
            ->width(215)
            ->height(80)
            ->useDisk('s3');
    }
}
