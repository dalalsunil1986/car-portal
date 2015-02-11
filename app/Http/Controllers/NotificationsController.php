<?php namespace App\Http\Controllers;

use App\Commands\CreateNotification;
use App\Src\Favorite\FavoriteRepository;
use App\Src\Notification\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class NotificationsController extends Controller {

    /**
     * @var NotificationRepository
     */
    public $notificationRepository;

    /**
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * @param Request $request
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $this->dispatchFrom(CreateNotification::class,$request);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        dd(Input::all());
        $car  = $this->carRepository->model->first(); // replace this with added car
        $user = Auth::user();
        Event::fire(new CarWasPosted($car, $user, $request));

//        $params = Input::all();
//        $params['user_id'] = Auth::user()->id;
//        $carNotificationRepository->create($params);
    }
}