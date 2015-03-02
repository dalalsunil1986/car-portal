<?php namespace App\Src\User;

class UserEventSubscriber
{

    public function subscribe($events)
    {
        $events->listen('user.*', 'Kuwaitii\User\Events\UserEventHandler');
    }

}
