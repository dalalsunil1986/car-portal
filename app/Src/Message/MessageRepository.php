<?php namespace App\Src\Message;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use Illuminate\Support\MessageBag;

class MessageRepository extends BaseRepository
{

    use CrudableTrait;

    public $model;

    /**
     * @param Message $model
     */
    public function __construct(Message $model)
    {
        $this->model = $model;

        parent::__construct(new MessageBag);
    }

    public function findThreadsForUser()
    {
    }


}