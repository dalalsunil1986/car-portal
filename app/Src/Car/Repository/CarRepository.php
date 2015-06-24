<?php
namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Src\Car\Car;

class CarRepository extends BaseRepository
{

    public $model;

    const MAXYEAR = '2015';
    const MAXMILEAGE = '300000';
    const MAXPRICE = '50000';


    public function __construct(Car $model)
    {
        $this->model = $model;
    }

    public function search($with = [])
    {
        return $this->model->with($with);
    }


}