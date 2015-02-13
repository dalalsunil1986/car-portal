<?php namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class CarMake extends BaseModel {

    use LocaleTrait;
    public static $name = 'carMake';

    protected $fillable = [];

    protected $table = 'car_makes';

    protected $dates = [''];

    protected $hidden = [];

    public $timestamps = false;

    protected $localeStrings = ['name'];

    protected $morphClass = 'CarMake';

    public function brands()
    {
        return $this->hasMany('App\Src\Car\CarBrand', 'make_id');
    }

    public function models()
    {
        return $this->hasManyThrough('App\Src\Car\CarModel', 'App\Src\Car\CarBrand', 'make_id', 'brand_id');
    }

    public function filters()
    {
        return $this->morphMany('App\Src\Notification\NotificationFilter', 'filterable');
    }
}
