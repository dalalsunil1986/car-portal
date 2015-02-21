<?php namespace App\Http\Composers;

use Auth;
use Illuminate\View\View;

class MessageComposer {

    /**
     * @param View $view
     */
    public function compose(View $view)
    {
        $user          = Auth::user();
        $messagesCount = $user->newMessagesCount();

        $view->with('newMessagesCount', $messagesCount);
    }
}