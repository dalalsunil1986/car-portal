<?php
namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Src\Car\CarBrand;


class CarBrandRepository extends BaseRepository
{

    public $model;

    public function __construct(CarBrand $model)
    {
        $this->model = $model;
    }

}