<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name', 'description', 'image', 'images', 'price', 'active', 'brand_id'
    ];
    protected $casts = [
        'images' => 'array',
        'colors' => 'array',
        'sizes' => 'array'
    ];

    protected static $logAttributes = ['name', 'description', 'image', 'images', 'price', 'active', 'brand_id', 'colors->color', 'colors->name', 'colors->available', 'sizes->size', 'sizes->available'];
//    protected static $logFillable = true;
    protected static $logName = 'Product';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
    public function ordersProducts()
    {
        return $this->hasMany(OrdersProduct::class);
    }


    // JoinTables:
    // products_colors : [ product_id: ..., colors: [ { color: '#555', available: true}, {...}, ... ] ]
    // products_shoe_sizes : [ product_id: ..., sizes: [ { size: 42, available: true}, {...}, ... ] ]
}
