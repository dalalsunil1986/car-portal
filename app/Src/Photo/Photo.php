<?php
namespace App\Src\Photo;

use App\Core\BaseModel;

class Photo extends BaseModel
{

    protected $guarded = ['id'];

    protected $table = 'photos';

    public function imageable()
    {
        return $this->morphTo();
    }

}
