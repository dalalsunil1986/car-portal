<?php namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;

class Car extends BaseModel {

    use LocaleTrait;

    protected $guarded = ['id'];

    protected $table = 'cars';

    protected $morphClass = 'Car';

    protected $localeStrings = ['name'];

    protected $with = ['model.brand'];

    // brand      => model => car
    // countries  => users =>  posts
    // make => brand => model
    // hasManyThrough

    public function user()
    {
        return $this->belongsTo('App\Src\User\User', 'user_id');
    }

    public function model()
    {
        return $this->belongsTo('App\Src\Car\CarModel', 'model_id');
    }

    public function favorites()
    {
        return $this->morphMany('App\Src\Favorite\Favorite', 'favoriteable');
    }

    public function favorited() {
        return $this->morphOne('App\Src\Favorite\Favorite', 'favoriteable')->where('user_id',1);
    }

    public function photos()
    {
        return $this->morphMany('App\Src\Photo\Photo', 'imageable');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Src\Photo\Photo', 'imageable')->where('thumbnail',1);
    }

    public function tags()
    {
        return $this->morphToMany('App\Src\Tag\Tag', 'taggable');
    }

    // view presenter
    public function getTitleAttribute()
    {
        return $this->year . ' ' . $this->model->brand->name . ' ' . $this->model->name;
    }

    public function threads()
    {
        return $this->morphMany('App\Src\Message\Thread','messageable');
    }

}
