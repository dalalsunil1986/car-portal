<?php namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use App\Src\Car\CarMake;
use Illuminate\Support\MessageBag;

class CarMakeRepository extends BaseRepository  {

    use CrudableTrait;

    public $model;

    public function __construct(CarMake $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }
}