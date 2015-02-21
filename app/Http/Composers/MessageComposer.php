<?php namespace App\Http\Composers;

use Auth;
use Illuminate\View\View;

class MessageComposer {

    /**
     * @param View $view
     * @return $this
     */
    public function compose(View $view)
    {
        if ( !Auth::check() ) {
            return $view->with('newMessagesCount', 0);
        }

        $user          = Auth::user();
        $messagesCount = $user->newMessagesCount();
        return $view->with('newMessagesCount', $messagesCount);
    }
}