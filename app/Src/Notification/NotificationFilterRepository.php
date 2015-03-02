<?php namespace App\Src\Notification;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use Illuminate\Support\MessageBag;

class NotificationFilterRepository extends BaseRepository
{

    use CrudableTrait;

    public $model;

    /**
     * @param NotificationFilter $model
     */
    public function __construct(NotificationFilter $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }


}