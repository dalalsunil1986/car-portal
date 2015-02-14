<?php namespace App\Handlers\Events;

use App\Events\CarWasPosted;

use App\Src\Notification\Car\CarNotificationRepository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Illuminate\Support\Facades\Mail;

class CarFilterNotification {

    /**
     * @var CarNotificationRepository
     */
    private $carNotificationRepository;

    /**
     * Create the event handler.
     * @param CarNotificationRepository $carNotificationRepository
     */
    public function __construct(CarNotificationRepository $carNotificationRepository)
    {
        //
        $this->carNotificationRepository = $carNotificationRepository;
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
        $makes       = $event->request->make;
        $brands      = $event->request->brand;
        $models      = $event->request->model;
        $types       = $event->request->type;
        $mileageFrom = $event->request->mileage_from;
        $mileageTo   = $event->request->mileage_to;
        $priceFrom   = $event->request->price_from;
        $priceTo     = $event->request->price_to;
        $yearFrom    = $event->request->year_from;
        $yearTo      = $event->request->year_to;

        $notifications = $this->carNotificationRepository->model->where('makes', $makes)->get();
        foreach ( $notifications as $notification ) {
            Mail::send('emails.welcome', [], function ($message) use ($notification) {
                $message->to($notification->user->email, $notification->user->name)->subject('Welcome!');
            });
        }

    }

}
