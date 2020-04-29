<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name', 'description', 'image', 'price', 'active', 'brand_id'
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    // JoinTables:
    // products_colors : [ product_id: ..., colors: [ { color: '#555', available: true}, {...}, ... ] ]
    // products_shoe_sizes : [ product_id: ..., sizes: [ { size: 42, available: true}, {...}, ... ] ]
}
