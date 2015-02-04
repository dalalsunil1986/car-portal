<?php namespace App\Src\Tag;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class Tag extends BaseModel {

    use LocaleTrait;

    protected $table = 'tags';
    protected $localeStrings = ['name'];
    protected $fillable = [];

    public function cars()
    {
        return $this->morphedByMany('Car', 'taggable');
    }

}