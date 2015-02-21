<?php namespace App\Src\User;

use App\Core\BaseModel;
use App\Src\Message\Participant;
use App\Src\Message\Thread;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function favorites()
    {
        return $this->morphMany('App\Src\Favorite\Favorite', 'favoriteable');
    }

    public function messages()
    {
        return $this->hasMany('App\Src\Message\Message', 'user_id');
    }

    public function participants()
    {
        return $this->hasMany('App\Src\Message\Participant', 'user_id');
    }

    /**
     * User relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function threads()
    {
        return $this->belongsToMany('App\Src\Message\Thread', 'participants');
    }

    /**
     * Returns the new messages count for user
     *
     * @return int
     */
    public function newMessagesCount()
    {
        return count($this->threadsWithNewMessages());
    }

    /**
     * Returns all threads with new messages
     *
     * @return array
     */
    public function threadsWithNewMessages()
    {
        $threadsWithNewMessages = [];
        $participants = Participant::where('user_id', $this->id)->lists('last_read', 'thread_id');

        if ($participants) {
            $threads = Thread::whereIn('id', array_keys($participants))->get();

            foreach ($threads as $thread) {
                if ($thread->updated_at > $participants[$thread->id]) {
                    $threadsWithNewMessages[] = $thread->id;
                }
            }
        }

        return $threadsWithNewMessages;
    }

    public function newMessages()
    {

    }
}
