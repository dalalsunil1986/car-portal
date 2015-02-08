<?php namespace App\Http\Controllers;

use App\Src\Favorite\FavoriteRepository;
use App\Src\Notification\NotificationRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class NotificationssController extends Controller {

    /**
     * @var NotificationRepository
     */
    private $carNotificationRepository;

    /**
     * @param NotificationRepository $carNotificationRepository
     */
    public function __construct(NotificationRepository $carNotificationRepository)
    {
        $this->carNotificationRepository = $carNotificationRepository;
    }


    /**
     * @param Request $request
     */
    public function store(Request $request) {
        // get the inputs and make it an array
//
        $car = $this->carRepository->model->first(); // replace this with added car
        $user = Auth::user();
        Event::fire(new CarWasPosted($car,$user,$request));

//        $params = Input::all();
//        $params['user_id'] = Auth::user()->id;
//        $carNotificationRepository->create($params);

        dd('aaa');
        dd(Input::all());
    }}