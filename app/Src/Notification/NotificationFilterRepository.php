<?php
namespace App\Src\Notification;

use App\Core\BaseRepository;

class NotificationFilterRepository extends BaseRepository
{

    public $model;

    /**
     * @param NotificationFilter $model
     */
    public function __construct(NotificationFilter $model)
    {
        $this->model = $model;
    }


}