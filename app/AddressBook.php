<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class AddressBook extends Model
{
    use LogsActivity;

    protected $fillable = [
        'firstName', 'lastName', 'address', 'additionalAddress', 'postalCode', 'city', 'country', 'phone'
    ];

    protected static $logFillable = true;
    protected static $logName = 'User';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
