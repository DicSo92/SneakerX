<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImagesProduct extends Model
{
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected $casts = [
        'images' => 'array'
    ];
}
