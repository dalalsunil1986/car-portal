<?php namespace App\Handlers\Events;

use App\Events\CarWasPosted;

use App\Src\Car\CarRepository;
use App\Src\Notification\Car\CarNotificationRepository;
use App\Src\Notification\NotificationRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Mail;

class CarFilterNotification {


    /**
     * Create the event handler.
     * @param NotificationRepository $notificationRepository
     */
    public function __construct(NotificationRepository $notificationRepository)
    {
        //
        $this->notificationRepository = $notificationRepository;
    }

    /**
     * Handle the event.
     *
     * @param  CarWasPosted $event
     * @internal param CarNotificationRepository $carNotificationRepository
     */
    public function handle(CarWasPosted $event)
    {
        // find the car filterer's who mathches with the car request
        // send them email
        $models      = $event->request->model;
        $mileageFrom = $event->request->mileage_from;
        $mileageTo   = $event->request->mileage_to;
        $priceFrom   = $event->request->price_from;
        $priceTo     = $event->request->price_to;
        $yearFrom    = $event->request->year_from;
        $yearTo      = $event->request->year_to;
//
//        $notifications = $this->notificationRepository->model->where('makes', $makes)->get();
//        foreach ( $notifications as $notification ) {
//            Mail::send('emails.welcome', [], function ($message) use ($notification) {
//                $message->to($notification->user->email, $notification->user->name)->subject('Welcome!');
//            });
//        }

        $carRepository = $event->carRepository;
        // get the car Model
        $carModel = $event->car->model;

        // find the filters for the specific model
        $filters = $carModel->filters()->with(['notification' => function ($query) use ($mileageFrom, $mileageTo, $priceFrom, $priceTo, $yearFrom, $yearTo, $carRepository) {
            if ( $mileageTo < $carRepository::MAXMILEAGE ) {
                $query->where('mileage_from', '>', $mileageFrom)->where('mileage', '<', $mileageTo);
            } else {
                $query->where('mileage', '>', $mileageFrom);
            }

            if ( $priceTo < $carRepository::MAXPRICE ) {
                $query->where('price', '>', $priceFrom)->where('price', '<', $priceTo);
            } else {
                $query->where('price', '>', $priceFrom);
            }

            if ( $yearTo < $carRepository::MAXYEAR ) {
                $query->where('year', '>', $yearFrom)->where('year', '<', $yearTo);
            } else {
                $query->where('year', '>', $yearFrom);
            }
        }])->get();

        dd($filters);
        foreach ( $filters as $filter ) {
            dd($filter->notification);
        }

        // get the model of the submitted car..
        // find any user who has filtered for this model
        // find any user who has filtered for the brand of this model
        // find any user who has filtered for the type of this model

        // for all queries match the year, mileage, price ...


    }

}
