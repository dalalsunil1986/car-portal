<?php
namespace App\Src\Notification;

use App\Core\BaseRepository;

class NotificationRepository extends BaseRepository
{

    public $model;

    /**
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        $this->model = $model;
    }

}