<?php
namespace App\Src\Car;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use App\Src\Car\Car;
use Illuminate\Support\MessageBag;

class CarRepository extends BaseRepository
{

    use CrudableTrait;

    const MAXYEAR = '2015';
    const MINYEAR = '1970';
    const YEARDEFAULTFROM = '1980'; // Defaulat Search Value If Search Value is not set
    const YEARDEFAULTTO = '2014';

    const MAXMILEAGE = '300000';
    const MINMILEAGE = '1000';
    const MILEAGEDEFAULTFROM = '3000';
    const MILEAGEDEFAULTTO = '100000';

    const MAXPRICE = '50000';
    const MINPRICE = '1000';
    const PRICEDEFAULTFROM = '2000';
    const PRICEDEFAULTTO = '40000';

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