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

    public function notifyMe($params)
    {
        $getMakes  = array_filter(explode(',', $params['make']));
        $getBrands = array_filter(explode(',', $params['brand']));
        $getModels = array_filter(explode(',', $params['model']));
        $getTypes  = array_filter(explode(',', $params['type']));
        $mileageFrom = $params['mileage-from'];
        $mileageTo   = $params['mileage-to'];
        $priceFrom   = $params['price-from'];
        $priceTo     = $params['price-to'];
        $yearFrom    = $params['year-from'];
        $yearTo      = $params['year-to'];

    }

}