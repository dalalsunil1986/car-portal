<?php namespace App\Src\Notification;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use Illuminate\Support\MessageBag;

class NotificationRepository extends BaseRepository  {

    use CrudableTrait;

    public $model;

    /**
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}