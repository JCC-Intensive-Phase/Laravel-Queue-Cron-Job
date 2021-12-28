<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'qty',
        'product_id',
        'user_id'
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // public function product()
    // {
    //     return $this->belongsTo(Product::class);
    // }
}