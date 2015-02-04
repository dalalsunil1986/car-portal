<?php namespace App\Src\Message;

use App\Core\BaseModel;

class Participant extends BaseModel {


    protected $guarded = ['id'];

    protected $table = 'participants';

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Src\User\User');
    }

    public function thread()
    {
        return $this->belongsTo('App\Src\Message\Thread');
    }


}
