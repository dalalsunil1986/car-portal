<?php
namespace App\Src\Notification;

use App\Core\BaseModel;

class NotificationFilter extends BaseModel
{

    protected $guarded = ['id'];

    protected $table = 'notification_filters';

    protected $morphClass = 'NotificationFilter';

    public $timestamps = false;

    protected $types = [
        'carmake'  => 'App\Src\Car\CarMake',
        'carbrand' => 'App\Src\Car\CarBrand',
        'cartype'  => 'App\Src\Car\CarType',
        'carmodel' => 'App\Src\Car\CarModel'
    ];


    public function notification()
    {
        return $this->belongsTo('App\Src\Notification\Notification', 'notification_id');
    }

    public function filterable()
    {
        return $this->morphTo();
    }


    public function getFilterableTypeAttribute($type)
    {
        // transform to lower case
        $type = strtolower($type);

        // to make sure this returns value from the array
        return array_get($this->types, $type, $type);
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('filterable_type', $type)->get();
    }

}
