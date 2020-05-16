<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Brand extends Model
{
    use LogsActivity;

    protected $fillable = ['name', 'description', 'banner', 'image'];

    protected static $logFillable = true;
    protected static $logName = 'Brand';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
