<?php namespace App\Src\Message;

use App\Core\BaseModel;

class Message extends BaseModel {

    public static $name = 'message';

    protected $guarded = ['id'];

    protected $hidden = [];

    protected $table = 'messages';

    protected $with = ['threads'];

    public function user()
    {
        return $this->belongsTo('App\Src\User\User');
    }

    public function threads()
    {
        return $this->belongsTo('App\Src\Message\Thread');
    }

    /**
     * Participants relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function participants()
    {
        return $this->hasMany('App\Src\Message\Participant', 'thread_id', 'thread_id');
    }

    /**
     * Recipients of this message
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function recipients()
    {
        return $this->participants()->where('user_id', '!=', $this->user_id)->get();
    }


}
