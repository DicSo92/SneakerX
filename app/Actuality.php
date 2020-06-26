<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Actuality extends Model
{
    use LogsActivity;

    protected $fillable = [
        'title', 'subtitle', 'content', 'image', 'published', 'published_date', 'user_id'
    ];

//    protected static $logAttributes = ['name', 'description', 'image', 'images', 'price', 'active', 'brand_id', 'colors->color', 'colors->name', 'colors->available', 'sizes->size', 'sizes->available'];
    protected static $logFillable = true;
    protected static $logName = 'Actuality';
    protected static $logOnlyDirty = true;
    protected static $submitEmptyLogs = false;


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
