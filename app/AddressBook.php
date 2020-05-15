<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    protected $fillable = [
        'firstName', 'lastName', 'address', 'additionalAddress', 'postalCode', 'city', 'country', 'phone'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
