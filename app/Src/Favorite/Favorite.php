<?php
namespace App\Src\Favorite;

use App\Core\BaseModel;

class Favorite extends BaseModel
{

    public static $name = 'favorite';

    protected $guarded = ['id'];

    protected $hidden = [];

    protected $table = 'favorites';

    protected $types = [
        'car' => 'App\Src\Car\Car',
        'job' => 'App\Src\Job\Job'
    ];

    public function favoriteable()
    {
        return $this->morphTo();
    }

    public function getFavoriteableTypeAttribute($type)
    {
        // transform to lower case
        $type = strtolower($type);

        // to make sure this returns value from the array
        return array_get($this->types, $type, $type);

        // which is always safe, because new 'class'
        // will work just the same as new 'Class'
    }

}
