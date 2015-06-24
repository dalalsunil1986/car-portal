<?php
namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Car\CarMake;
use App\Src\Car\CarModel;
use App\Src\Notification\NotificationFilter;

class CarBrand extends BaseModel
{

    use LocaleTrait;

    public static $name = 'carBrand';

    protected $guarded = ['id'];

    protected $table = 'car_brands';

    public $timestamps = false;

    protected $localeStrings = ['name'];

    protected $morphClass = 'CarBrand';

    public function make()
    {
        return $this->belongsTo(CarMake::class, 'make_id');
    }

    public function models()
    {
        return $this->hasMany(CarModel::class, 'brand_id');
    }

    public function filters()
    {
        return $this->morphMany(NotificationFilter::class, 'filterable');
    }

}
