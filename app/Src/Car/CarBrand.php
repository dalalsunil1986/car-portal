<?php namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class CarBrand extends BaseModel {

    use LocaleTrait;
    
    public static $name = 'carBrand';

    protected $fillable = [];

    protected $table = 'car_brands';

    protected $dates = [''];

    protected $hidden = [];

    public $timestamps = false;

    protected $localeStrings = ['name'];

    public function make()
    {
        return $this->belongsTo('App\Src\Car\CarMake', 'make_id');
    }

    public function models()
    {
        return $this->hasMany('App\Src\Car\CarModel', 'brand_id');
    }

}
