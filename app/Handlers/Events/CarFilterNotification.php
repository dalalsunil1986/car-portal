<?php namespace App\Handlers\Events;

use App\Events\CarWasPosted;

use App\Src\Car\CarRepository;
use App\Src\Notification\NotificationRepository;
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
        $models        = $event->request->model;
        $mileageFrom   = $event->request->mileage_from;
        $mileageTo     = $event->request->mileage_to;
        $priceFrom     = $event->request->price_from;
        $priceTo       = $event->request->price_to;
        $yearFrom      = $event->request->year_from;
        $yearTo        = $event->request->year_to;
        $carRepository = $event->carRepository;
        $car           = $event->car;
        $carModel      = $event->car->model;
        $carBrand      = $carModel->brand;
        $carMake       = $carBrand->make;
        $carType       = $carModel->type;

        // task => Notify all users for the filter
        // 1- get all the filters for the car model

        // 2- get all the filters for the car brand

        // 3- get all the filters for the car type

        // 4- get all the filters for the car make


        // get all the notifications for all the requests and group by user_id

        // get the users and send them message


        // 1
        $modelFilters = $carModel->filters;

        $brandFilters = $carBrand->filters;

        $makeFilters = $carMake->filters;

        $typeFilters = $carType->filters;

        $mergedFilters = $modelFilters->merge($brandFilters, $makeFilters, $typeFilters);

        $notificationIds = $mergedFilters->lists('notification_id');
        $notifications   = $this->notificationRepository->model->with(['user'])
            ->whereIn('id', $notificationIds)
            ->where('mileage_from', '>', $car->mileage)
            ->where('mileage_to', '<', $car->mileage)
            ->where('year_from', '>', $car->year)
            ->groupBy('user_id')
//            ->where('year_to', '<', $car->year)
//            ->where('price_from', '>', $car->price)
//            ->where('price_to', '<', $car->price)
            ->get();

        foreach ( $notifications as $notification ) {
            Mail::send('emails.welcome', [], function ($message) use ($notification) {
                $message->to($notification->user->email, $notification->user->name)->subject('a car has been posted !');
            });
        }
        dd($notifications->toArray());

//        $notifications   = $this->notificationRepository->model
//            ->whereIn('id', $notificationIds)
//            ->where('mileage_from', function ($query) use ($car, $mileageFrom, $mileageTo, $priceFrom, $priceTo, $yearFrom, $yearTo, $carRepository) {
//                if ( $mileageTo <= $carRepository::MAXMILEAGE ) {
//                    $query->where('mileage_froms', '>', $car->mileage)->where('mileage_to', '<', $car->mileage);
//                } else {
//                    $query->where('mileage_from', '>', $car->mileage);
//                }
//            })
//            ->where('year_from', function ($query) use ($car, $mileageFrom, $mileageTo, $priceFrom, $priceTo, $yearFrom, $yearTo, $carRepository) {
//                if ( $yearTo <= $carRepository::MAXYEAR ) {
//                    $query->where('year_froms', '>', $car->year)->where('year_to', '<', $car->year);
//                } else {
//                    $query->where('year_from', '>', $car->year);
//                }
//            })
//            ->where('price_from', function ($query) use ($car, $mileageFrom, $mileageTo, $priceFrom, $priceTo, $yearFrom, $yearTo, $carRepository) {
//
//                if ( $priceTo <= $carRepository::MAXPRICE ) {
//                    $query->where('price_from', '>', $car->price)->where('price_to', '<', $car->price);
//                } else {
//                    $query->where('price_from', '>', $car->price);
//                }
//
//            })
//            ->get();

    }


//    public function handle(CarWasPosted $event)
//    {
//        // find the car filterer's who mathches with the car request
//        // send them email
//        $models      = $event->request->model;
//        $mileageFrom = $event->request->mileage_from;
//        $mileageTo   = $event->request->mileage_to;
//        $priceFrom   = $event->request->price_from;
//        $priceTo     = $event->request->price_to;
//        $yearFrom    = $event->request->year_from;
//        $yearTo      = $event->request->year_to;
////
////        $notifications = $this->notificationRepository->model->where('makes', $makes)->get();
////        foreach ( $notifications as $notification ) {
////            Mail::send('emails.welcome', [], function ($message) use ($notification) {
////                $message->to($notification->user->email, $notification->user->name)->subject('Welcome!');
////            });
////        }
//
////        notification
////        +----+------+---------+-----------+---------+--------------+------------+------------+----------
////        | id | type | user_id | year_from | year_to | mileage_from | mileage_to | price_from | price_to
////        +----+------+---------+-----------+---------+--------------+------------+------------+----------+---
////        |  1 | Car  |       1 | 2005      | 2014    | 6000         | 100000     | 1000       | 10000    |
//
////        car
////        +----+---------+----------+------+---------+-------+-------------
////        | id | user_id | model_id | year | mileage | price | description | mobile
////        +----+---------+----------+------+---------+-------+-------------+---
////        |  1 |       2 |        8 | 1985 |    8411 | 15127 | NULL        | 178
////        +----+---------+----------+------+---------+-------+-------------+---
//
//        $carRepository = $event->carRepository;
//        // get the car Model
//        $car      = $event->car;
//        $carModel = $event->car->model;
//
//        // find the filters for the specific model
//        $filters = $carModel->filters()->with([
//            'notification' =>
//                function ($query) use ($car, $mileageFrom, $mileageTo, $priceFrom, $priceTo, $yearFrom, $yearTo, $carRepository) {
//                    if ( $mileageTo <= $carRepository::MAXMILEAGE ) {
//                        $query->where('mileage_from', '>', $car->mileage)->where('mileage_to', '<', $car->mileage);
//                    } else {
//                        $query->where('mileage_from', '>', $car->mileage);
//                    }
//
//                    if ( $priceTo <= $carRepository::MAXPRICE ) {
//                        $query->where('price_from', '>', $car->price)->where('price_to', '<', $car->price);
//                    } else {
//                        $query->where('price_from', '>', $car->price);
//                    }
//
//                    if ( $yearTo <= $carRepository::MAXYEAR ) {
//                        $query->where('year_froms', '>', $car->year)->where('year_to', '<', $car->year);
//                    } else {
//                        $query->where('year_from', '>', $car->year);
//                    }
//
//                },
//
//        ])->get();
//
//        dd($filters);
//        foreach ( $filters as $filter ) {
//
//            dd($filter->notification);
//        }
//
//        // get the model of the submitted car..
//        // find any user who has filtered for this model
//        // find any user who has filtered for the brand of this model
//        // find any user who has filtered for the type of this model
//
//        // for all queries match the year, mileage, price ...
//
//
//    }

}
