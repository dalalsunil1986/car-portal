<?php namespace App\Src\Car;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use App\Src\Car\Car;
use Illuminate\Support\MessageBag;

class CarRepository extends BaseRepository {

    use CrudableTrait;

    public $model;

    public function __construct(Car $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

    public function findAll($with = [])
    {
        return $this->model->with($with)->get();
    }

    public function search($with = [])
    {
        return $this->model->with($with);
    }

}