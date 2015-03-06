<?php
namespace App\Events;

use App\Src\Car\CarRepository;
use Illuminate\Queue\SerializesModels;

class CarWasPosted extends Event
{

    use SerializesModels;
    /**
     * @var
     */
    public $request;
    /**
     * @var User
     */
    public $user;
    /**
     * @var
     */
    public $car;
    /**
     * @var CarRepository
     */
    public $carRepository;

    /**
     * Create a new event instance.
     * @param $car
     * @param $user
     * @param $request
     * @param CarRepository $carRepository
     */
    public function __construct($car, $user, $request, $carRepository)
    {
        $this->car           = $car;
        $this->user          = $user;
        $this->request       = $request;
        $this->carRepository = $carRepository;
    }

}
