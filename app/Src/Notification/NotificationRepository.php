<?php namespace App\Src\Notification;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use Illuminate\Support\MessageBag;

class NotificationRepository extends BaseRepository  {

    use CrudableTrait;

    public $model;

    /**
     * @param CarNotification $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct(new MessageBag);

        $this->model = $model;
    }

//    public function create($params)
//    {
//        $makes       = $params['make'];
//        $brands      = $params['brand'];
//        $models      = $params['model'];
//        $types       = $params['type'];
//        $mileageFrom = $params['mileage-from'];
//        $mileageTo   = $params['mileage-to'];
//        $priceFrom   = $params['price-from'];
//        $priceTo     = $params['price-to'];
//        $yearFrom    = $params['year-from'];
//        $yearTo      = $params['year-to'];
//        $userId      = $params['user_id'];
//
//        return $this->model->create(['user_id'=>$userId,'makes' => $makes, 'brands' => $brands, 'types' => $types, 'models' => $models, 'mileage_from' => $mileageFrom, 'mileage_to' => $mileageTo, 'price_from' => $priceFrom, 'price_to' => $priceTo, 'year_from' => $yearFrom, 'year_to' => $yearTo]);
//
//    }

}