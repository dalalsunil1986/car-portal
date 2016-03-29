<?php
namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class CarBrand extends BaseModel
{

    use LocaleTrait;

    public $timestamps = false;
    protected $guarded = ['id'];
    protected $table = 'car_brands';
    protected $localeStrings = ['name'];
    protected $morphClass = 'CarBrand';

    public function make()
    {
        return $this->belongsTo('App\Src\Car\CarMake', 'make_id');
    }

    public function models()
    {
        return $this->hasMany('App\Src\Car\CarModel', 'brand_id');
    }

    public function filters()
    {
        return $this->morphMany('App\Src\Notification\NotificationFilter', 'filterable');
    }

}
