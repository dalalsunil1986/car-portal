<?php
namespace App\Src\Notification;

use App\Core\BaseModel;
use App\Src\Notification\NotificationFilter;
use App\Src\User\User;

class Notification extends BaseModel
{

    protected $guarded = ['id'];

    protected $table = 'notifications';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function filters()
    {
        return $this->hasMany(NotificationFilter::class, 'notification_id');
    }

}
