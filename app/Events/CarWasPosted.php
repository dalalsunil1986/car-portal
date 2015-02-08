<?php namespace App\Events;

use Illuminate\Queue\SerializesModels;

class CarWasPosted extends Event {

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
	 * Create a new event instance.
	 * @param $car
	 * @param $user
	 * @param $request
	 */
	public function __construct($car,$user,$request)
	{
		$this->car = $car;
		$this->user = $user;
		$this->request = $request;
	}

}
