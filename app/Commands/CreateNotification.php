<?php namespace App\Commands;

use App\Src\Car\Repository\CarBrandRepository;
use App\Src\Car\Repository\CarMakeRepository;
use App\Src\Car\Repository\CarModelRepository;
use App\Src\Car\Repository\CarTypeRepository;
use App\Src\Notification\NotificationRepository;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class CreateNotification extends Command implements SelfHandling {

    use SerializesModels;
    /**
     * @var
     */
    private $make;
    /**
     * @var
     */
    private $brand;
    /**
     * @var
     */
    private $model;
    /**
     * @var
     */
    private $type;
    /**
     * @var
     */
    private $priceFrom;
    /**
     * @var
     */
    private $priceTo;
    /**
     * @var
     */
    private $mileageFrom;
    /**
     * @var
     */
    private $mileageTo;
    /**
     * @var
     */
    private $yearFrom;
    /**
     * @var
     */
    private $yearTo;
    /**
     * @var
     */
    private $user;
    /**
     * @var
     */
    private $filterType;

    /**
     * Create a new command instance.
     *
     * @param filter_type
     * @param $make
     * @param $brand
     * @param $model
     * @param $type
     * @param $price_from
     * @param $price_to
     * @param $mileage_from
     * @param $mileage_to
     * @param $year_from
     * @param $year_to
     * @internal param $user
     */
    public function __construct($filter_type, $make, $brand, $model, $type, $price_from, $price_to, $mileage_from, $mileage_to, $year_from, $year_to)
    {
        $this->make        = $make;
        $this->brand       = $brand;
        $this->model       = $model;
        $this->type        = $type;
        $this->priceFrom   = $price_from;
        $this->priceTo     = $price_to;
        $this->mileageFrom = $mileage_from;
        $this->mileageTo   = $mileage_to;
        $this->yearFrom    = $year_from;
        $this->yearTo      = $year_to;
        $this->filterType  = $filter_type;
    }

    /**
     * Execute the command.
     *
     * @param NotificationRepository $notificationRepository
     * @param CarMakeRepository $carMakeRepository
     * @param CarBrandRepository $carBrandRepository
     * @param CarModelRepository $carModelRepository
     * @param CarTypeRepository $carTypeRepository
     */
    public function handle(NotificationRepository $notificationRepository, CarMakeRepository $carMakeRepository, CarBrandRepository $carBrandRepository, CarModelRepository $carModelRepository, CarTypeRepository $carTypeRepository)
    {
        $makes  = array_filter(explode(',', $this->make));
        $brands = array_filter(explode(',', $this->brand));
        $models = array_filter(explode(',', $this->model));
        $types  = array_filter(explode(',', $this->type));

        $notification = $notificationRepository->model->create([
            'type'         => ucfirst($this->filterType),
            'user_id'      => Auth::user()->id,
            'year_from'    => $this->yearFrom,
            'year_to'      => $this->yearTo,
            'mileage_from' => $this->mileageFrom,
            'mileage_to'   => $this->mileageTo,
            'price_from'   => $this->priceFrom,
            'price_to'     => $this->priceTo
        ]);

        foreach ( $makes as $make ) {
            $carMakeModel = $carMakeRepository->model->find($make);

            $carMakeModel->filters()->create(['notification_id' => $notification->id]);
        }

        foreach ( $brands as $brand ) {
            $carBrandModel = $carBrandRepository->model->find($brand);

            $carBrandModel->filters()->create(['notification_id' => $notification->id]);
        }

        foreach ( $models as $model ) {
            $carModelModel = $carModelRepository->model->find($model);

            $carModelModel->filters()->create(['notification_id' => $notification->id]);
        }

        foreach ( $types as $type ) {
            $carTypeModel = $carTypeRepository->model->find($type);

            $carTypeModel->filters()->create(['notification_id' => $notification->id]);
        }

        dd('done');
    }


}
