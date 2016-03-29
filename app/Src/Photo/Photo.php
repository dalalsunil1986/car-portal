<?php
namespace App\Src\Photo;

use App\Core\BaseModel;

class Photo extends BaseModel
{

    public static $name = 'photo';

    protected $guarded = ['id'];

    protected $hidden = [];

    protected $table = 'photos';

    public function imageable()
    {
        return $this->morphTo();
    }

}
