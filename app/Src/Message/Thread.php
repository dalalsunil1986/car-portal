<?php namespace App\Src\Message;

use App\Core\BaseModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Thread extends BaseModel {

    protected $guarded = ['id'];

    protected $table = 'threads';

    public $timestamps = true;

    public function messages()
    {
        return $this->hasMany('App\Src\Message\Message');
    }

    public function participants()
    {
        return $this->hasMany('App\Src\Message\Participant');
    }

    /**
     * Returns the latest message from a thread
     */
    public function latestMessage()
    {
        return $this->hasOne('App\Src\Message\Message')->latest();
    }

    /**
     * Returns threads that the user is associated with
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeForUser($query, $userId)
    {
        return $query->join('participants', 'threads.id', '=', 'participants.thread_id')
            ->where('participants.user_id', $userId)
            ->where('participants.deleted_at', null)
            ->select('threads.*')
            ->latest('updated_at')
            ->get();
    }

    /**
     * Returns threads with new messages that the user is associated with
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeForUserWithNewMessages($query, $userId)
    {
        return $query->join('participants', 'threads.id', '=', 'participants.thread_id')
            ->where('participants.user_id', $userId)
            ->where('participants.deleted_at', null)
            ->where('threads.updated_at', '>', DB::raw('participants.last_read'))
            ->select('threads.*')
            ->latest('updated_at')
            ->get();
    }

    /**
     * @param int $paginate
     * @return mixed Get Threads Related to the Authenticated User
     * Get Threads Related to the Authenticated User
     * @todo: Replace 1 with Auth
     */
    public function getUserThreads($paginate = 15)
    {
        return $this->whereHas('messages', function ($q) {
            $q->where('recepient_id', Auth::user()->id)// Replace 1 with Auth::user()->id
            ->orWhere('sender_id', Auth::user()->id);
        })->paginate($paginate);
    }

    public function messageable()
    {
        return $this->morphTo();
    }

    /**
     * Finds the participant record from a user id
     *
     * @param $userId
     * @return mixed
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     */
    public function getParticipantFromUser($userId)
    {
        return $this->participants()->where('user_id', $userId)->firstOrFail();
    }

    /**
     * Mark a thread as read for a user
     *
     * @param integer $userId
     */
    public function markAsRead($userId)
    {
        $participant = $this->getParticipantFromUser($userId);
        $participant->last_read = new Carbon;
        $participant->save();
    }
}
