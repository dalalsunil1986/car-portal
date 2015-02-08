<?php namespace App\Src\Notification;

use App\Core\BaseModel;

class NotificationFilter extends BaseModel {

    protected $guarded = ['id'];

    protected $table = 'notification_filters';

}
