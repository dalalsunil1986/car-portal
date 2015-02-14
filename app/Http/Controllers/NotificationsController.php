<?php namespace App\Http\Controllers;

use App\Commands\CreateNotification;
use App\Events\CarWasPosted;
use App\Src\Car\Car;
use App\Src\Car\CarRepository;
use App\Src\Favorite\FavoriteRepository;
use App\Src\Notification\NotificationRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
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
        $this->dispatchFrom(CreateNotification::class,$request);
    }

    /**
     * @param Request $request
     * @param CarRepository $carRepository
     */
    public function store(Request $request, CarRepository $carRepository)
    {
        $car = new Car();
        Event::fire(new CarWasPosted($car->find(6), Auth::user(), $request,$carRepository));
//        $car  = $this->carRepository->model->first(); // replace this with added car
//        $user = Auth::user();
//        Event::fire(new CarWasPosted($car, $user, $request));

//        $params = Input::all();
//        $params['user_id'] = Auth::user()->id;
//        $carNotificationRepository->create($params);
    }
}