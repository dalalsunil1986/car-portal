<?php
namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Src\Car\CarModel;

class CarModelRepository extends BaseRepository
{

    public $model;

    public function __construct(CarModel $model)
    {
        $this->model = $model;
    }

}