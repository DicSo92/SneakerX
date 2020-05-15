<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'email', 'totalPrice', 'paymentStatus', 'deliveryStatus',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function ordersProducts()
    {
        return $this->hasMany(OrdersProduct::class);
    }

    public function ordersBillingAddresses()
    {
        return $this->hasOne(OrdersBillingAddress::class);
    }
    public function ordersDeliveryAddresses()
    {
        return $this->hasOne(OrdersDeliveryAddress::class);
    }
}
