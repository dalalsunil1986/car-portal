<?php
namespace App\Src\Car;

use App\Core\LocaleTrait;
use App\Core\BaseModel;

class CarType extends BaseModel
{

    use LocaleTrait;
    public static $name = 'carMake';

    protected $fillable = [];

    protected $table = 'car_types';

    protected $dates = [''];

    protected $hidden = [];

    public $timestamps = false;

    protected $localeStrings = ['name'];

    protected $morphClass = 'CarType';

    public function brands()
    {
        return $this->hasMany('App\Src\Car\CarBrand', 'make_id');
    }

    public function models()
    {
        return $this->hasMany('App\Src\Car\CarModel', 'type_id');
    }

    public function filters()
    {
        return $this->morphMany('App\Src\Notification\NotificationFilter', 'filterable');
    }
}
