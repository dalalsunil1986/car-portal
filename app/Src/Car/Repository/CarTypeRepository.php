<?php namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use App\Src\Car\CarType;
use Illuminate\Support\MessageBag;


class CarTypeRepository extends BaseRepository
{

    use CrudableTrait;

    public $model;

    public function __construct(CarType $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}