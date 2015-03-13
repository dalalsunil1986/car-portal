<?php
namespace App\Http\Controllers;

use App\Commands\CreateNotification;
use App\Events\CarWasPosted;
use App\Src\Car\Car;
use App\Src\Car\CarRepository;
use App\Src\Favorite\FavoriteRepository;
use App\Src\Notification\Notification;
use App\Src\Notification\NotificationFilter;
use App\Src\Notification\NotificationRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class NotificationsController extends Controller
{

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
        Auth::loginUsingId(1);
    }

    /**
     * @param Request $request
     */
    public function store(Request $request)
    {
        $this->dispatchFrom(CreateNotification::class, $request);
    }

    /**
     * @param Request $request
     * @param CarRepository $carRepository
     * Test Notification
     */
    public function test(Request $request, CarRepository $carRepository)
    {
        $filterModel       = new NotificationFilter();
        $notificationModel = new Notification();

        $notificationArray = [
            'user_id'      => Auth::user()->id,
            'type'         => 'Car',
            'price_from'   => '2000',
            'price_to'     => '3000',
            'mileage_from' => '10000',
            'mileage_to'   => '200000',
            'year_from'    => '2000',
            'year_to'      => '2013'
        ];

        $notification = $notificationModel->create($notificationArray);

        $filterArray = [
            'notification_id' => $notification->id,
            'filterable_id'   => '2',
            'filterable_type' => 'CarModel'
        ];
        $filterModel->create($filterArray);

        $carModel = new Car();
        $carArray = [
            'model_id' => '2',
            'price'    => '2500',
            'mileage'  => '30000',
            'year'     => '2010'
        ];
        $car      = $carModel->create($carArray);

        Event::fire(new CarWasPosted($car, Auth::user(), $request, $carRepository));

    }

}