<?php namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class CarModel extends BaseModel {

    use LocaleTrait;
    public static $name = 'carModel';

    protected $fillable = [];

    protected $table = 'car_models';

    protected $dates = [''];

    protected $hidden = [];

    public $timestamps = false;

    protected $localeStrings = ['name'];

    public function cars()
    {
        return $this->hasMany('App\Src\Car\Car', 'model_id');
    }

    public function brand()
    {
        return $this->belongsTo('App\Src\Car\CarBrand', 'brand_id');
    }

    public function make()
    {
        return $this->hasManyThrough('App\Src\Car\Car', 'User');
    }

}

