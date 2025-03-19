<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'author',
        'publisher',
        'category',
        'stock',
        'price',
        'image_name'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
