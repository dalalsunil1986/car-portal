<?php
namespace App\Src\Car;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use App\Src\Car\Car;
use Illuminate\Support\MessageBag;

class CarRepository extends BaseRepository
{

    use CrudableTrait;

    public $model;

    const MAXYEAR = '2015';
    const MAXMILEAGE = '300000';
    const MAXPRICE = '50000';


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