<?php namespace App\Src\Message;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use Illuminate\Support\MessageBag;

class ThreadRepository extends BaseRepository {

    use CrudableTrait;

    public $model;

    /**
     * @param Thread $model
     */
    public function __construct(Thread $model)
    {
        $this->model = $model;

        parent::__construct(new MessageBag);
    }

    public function getMessagesByThread($threadID)
    {
        return $this->model->with(['messages.user'])->whereHas('messages', function ($q) {
            $q->latest();
        })->find($threadID);
    }


}