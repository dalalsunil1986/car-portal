<?php namespace App\Src\Favorite;

use App\Core\BaseModel;

class Favorite extends BaseModel {

    public static $name = 'favorite';

    protected $guarded = ['id'];

    protected $hidden = [];

    protected $table = 'favorites';

    public function favoriteable()
    {
        return $this->morphTo();
    }

}
