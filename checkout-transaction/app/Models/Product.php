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
        'image_url'
    ];

    // public function transactions()
    // {
    //     return $this->hasMany(Transaction::class);
    // }


    public function registerMediaConversions(Media $media = null)
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
