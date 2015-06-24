<?php
namespace App\Src\Car;

use App\Core\BaseModel;
use App\Core\LocaleTrait;
use App\Src\Car\CarModel;
use App\Src\Favorite\Favorite;
use App\Src\Message\Thread;
use App\Src\Photo\Photo;
use App\Src\Tag\Tag;
use App\Src\User\User;
use Auth;

class Car extends BaseModel
{

    use LocaleTrait;

    protected $guarded = ['id'];

    protected $table = 'cars';

    protected $morphClass = 'Car';

    protected $localeStrings = ['name'];

    protected $with = ['model.brand'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class, 'model_id');
    }

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favoriteable');
    }

    public function favorited()
    {
        return $this->morphOne(Favorite::class, 'favoriteable')->where('user_id',
            Auth::user()->id)->select(['id', 'user_id', 'favoriteable_id', 'favoriteable_type']);
    }

    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }

    public function thumbnail()
    {
        return $this->morphOne(Photo, 'imageable')->where('thumbnail', 1);
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    public function threads()
    {
        return $this->morphMany(Thread::class, 'messageable');
    }

    // view presenter
    public function getTitleAttribute()
    {
        return $this->year . ' ' . $this->model->brand->name . ' ' . $this->model->name;
    }


}
