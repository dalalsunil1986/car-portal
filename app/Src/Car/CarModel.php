<?php
namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class CarModel extends BaseModel
{

    use LocaleTrait;
    public static $name = 'carModel';

    protected $guarded = ['id'];

    protected $table = 'car_models';

    public $timestamps = false;

    protected $localeStrings = ['name'];

    protected $morphClass = 'CarModel';

    public function cars()
    {
        return $this->hasMany('App\Src\Car\Car', 'model_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Src\Car\CarBrand', 'brand_id');
    }

    public function type()
    {
        return $this->belongsTo('App\Src\Car\CarType', 'type_id');
    }

    public function filters()
    {
        return $this->morphMany('App\Src\Notification\NotificationFilter', 'filterable');
    }

}

