<?php namespace App\Src\Notification;

use App\Core\BaseModel;

class NotificationFilter extends BaseModel {

    protected $guarded = ['id'];

    protected $table = 'notification_filters';

    protected $morphClass = 'NotificationFilter';

    public $timestamps = false;

    public function notification()
    {
        return $this->belongsTo('App\Src\Notification\Notification', 'notification_id');
    }

    public function filterable()
    {
        return $this->morphTo();
    }
}
