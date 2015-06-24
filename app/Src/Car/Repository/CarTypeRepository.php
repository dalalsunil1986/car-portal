<?php
namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Src\Car\CarType;


class CarTypeRepository extends BaseRepository
{

    public $model;

    public function __construct(CarType $model)
    {
        $this->model = $model;
    }

}