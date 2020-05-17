<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Order extends Model
{
    use LogsActivity;

    protected $fillable = [
        'email', 'totalPrice', 'paymentStatus', 'deliveryStatus',
    ];

    protected static $logFillable = true;
    protected static $logName = 'Order';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


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
