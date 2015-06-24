<?php
namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Src\Car\CarMake;

class CarMakeRepository extends BaseRepository
{

    public $model;

    public function __construct(CarMake $model)
    {
        $this->model = $model;
    }
}