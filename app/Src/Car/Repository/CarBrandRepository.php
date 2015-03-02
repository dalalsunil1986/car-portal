<?php namespace App\Src\Car\Repository;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use App\Src\Car\CarBrand;
use Illuminate\Support\MessageBag;


class CarBrandRepository extends BaseRepository
{

    use CrudableTrait;

    public $model;

    public function __construct(CarBrand $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

}