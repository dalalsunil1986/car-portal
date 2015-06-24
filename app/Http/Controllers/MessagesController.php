<?php
namespace App\Http\Controllers;

use App\Src\Message\MessageRepository;
use App\Src\Message\ThreadRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class MessagesController extends Controller
{

    /**
     * @var MessageRepository
     */
    private $messageRepository;
    /**
     * @var ThreadRepository
     */
    private $threadRepository;

    /**
     * @param MessageRepository $messageRepository
     * @param ThreadRepository $threadRepository
     */
    public function __construct(MessageRepository $messageRepository, ThreadRepository $threadRepository)
    {
        $this->messageRepository = $messageRepository;
        $this->threadRepository  = $threadRepository;
        Auth::loginUsingId(2);
    }

    /**
     * @return \Illuminate\View\View
     * Returns all the Threads For the Current User With the Latest Message
     */
    public function index()
    {
        $user = Auth::user();

        // get all the messages by thread for current user
        $threads = $this->threadRepository->model->with('latestMessage')->forUser($user->id);

        return view('module.messages.index', compact('threads'));
    }

    /**
     * @param $threadID
     * Show Messages For Threads
     * @return \Illuminate\View\View
     */
    public function show($threadID)
    {
        $user   = Auth::user();
        $thread = $this->threadRepository->getMessagesByThread($threadID);
        //@todo: If this Thread is not assosiated with this user, then redirect

        $thread->markAsRead($user->id);

        return view('module.messages.view', compact('thread'));
    }

    /**
     * @return mixed
     * Create a Thread and Attach Messages
     */
    public function store()
    {
        // Create a thread
        // Attach Users to the Thread
        // Create Message
        $val = $this->messageRepository->getCreateForm();

        if (!$val->isValid()) {
            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $messageableId   = Input::get('messageable_id');
        $messageableType = Input::get('messageable_type');

        // Resolve the Repository Class
        $repo = App::make('App\\Src\\' . $messageableType . '\\' . $messageableType . 'Repository');

        // Resolve the Model
        $record = $repo->model->findOrFail($messageableId);

        // Attach The THreads to The Model
        $thread = $record->threads()->create(['subject' => Input::get('subject')]);

        $data = array_merge(['thread_id' => $thread->id, 'user_id' => Auth::user()->id], $val->getInputData());

        // Attach The Message to the Thread
        $thread->messages()->create($data);

        // Attach Participants
        $thread->participants()->create(['user_id' => Auth::user()->id]);
        $thread->participants()->create(['user_id' => $record->user_id]);

        return Redirect::back()->with('success', trans('word.sent'));

    }

    public function update($id)
    {
        $val = $this->messageRepository->getEditForm($id);

        if (!$val->isValid()) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $thread = $this->threadRepository->model->find($id);

        $data = array_merge(['thread_id' => $thread->id, 'user_id' => Auth::user()->id], $val->getInputData());

        $thread->messages()->create($data);

        return Redirect::back()->with('success', trans('word.saved'));
    }

    public function destroy($id)
    {
        $message = $this->messageRepository->findById($id);
        $message->delete();
    }


}