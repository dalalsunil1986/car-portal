<?php namespace App\Commands;

use App\Src\Car\CarMake;
use App\Src\Car\Repository\CarBrandRepository;
use App\Src\Car\Repository\CarMakeRepository;
use App\Src\Car\Repository\CarModelRepository;
use App\Src\Car\Repository\CarTypeRepository;
use App\Src\Notification\NotificationFilter;
use App\Src\Notification\NotificationFilterRepository;
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
     * @param $filterType
     * @param $selectedMakes
     * @param $selectedBrands
     * @param $selectedModels
     * @param $selectedTypes
     * @param $priceFrom
     * @param $priceTo
     * @param $mileageFrom
     * @param $mileageTo
     * @param $yearFrom
     * @param $yearTo
     * @internal param $user
     */
    public function __construct($filterType, $selectedMakes, $selectedBrands, $selectedModels, $selectedTypes, $priceFrom, $priceTo, $mileageFrom, $mileageTo, $yearFrom, $yearTo)
    {
        $this->filterType  = $filterType;
        $this->make        = $selectedMakes;
        $this->brand       = $selectedBrands;
        $this->model       = $selectedModels;
        $this->type        = $selectedTypes;
        $this->priceFrom   = $priceFrom;
        $this->priceTo     = $priceTo;
        $this->mileageFrom = $mileageFrom;
        $this->mileageTo   = $mileageTo;
        $this->yearFrom    = $yearFrom;
        $this->yearTo      = $yearTo;
    }

    /**
     * Execute the command.
     *
     * @param NotificationRepository $notificationRepository
     * @param CarMakeRepository $carMakeRepository
     * @param CarBrandRepository $carBrandRepository
     * @param CarModelRepository $carModelRepository
     * @param CarTypeRepository $carTypeRepository
     * @param NotificationFilterRepository $notificationFilterRepository
     * @return bool
     */
    public function handle(NotificationRepository $notificationRepository, CarMakeRepository $carMakeRepository, CarBrandRepository $carBrandRepository, CarModelRepository $carModelRepository, CarTypeRepository $carTypeRepository, NotificationFilterRepository $notificationFilterRepository)
    {
        $makes  = array_filter($this->make);
        $brands = array_filter($this->brand);
        $models = array_filter($this->model);
        $types  = array_filter($this->type);

        $notification = $notificationRepository->model->create([
            'type'         => ucfirst($this->filterType), // Car,Job
            'user_id'      => Auth::user()->id,
            'year_from'    => $this->yearFrom,
            'year_to'      => $this->yearTo,
            'mileage_from' => $this->mileageFrom,
            'mileage_to'   => $this->mileageTo,
            'price_from'   => $this->priceFrom,
            'price_to'     => $this->priceTo
        ]);

        // if model is set, ignore the rest ..
        // if types are set, ignore the rest except models
        // if brands are set, ignore the rest except models and make
        // if makes are set, include everything

        if ( $models ) {
            foreach ( $models as $model ) {
                $carModelModel = $carModelRepository->model->find($model);
                $carModelModel->filters()->create(['notification_id' => $notification->id]);
            }
        } elseif ( $brands ) {
            foreach ( $brands as $brand ) {
                $carBrandModel = $carBrandRepository->model->find($brand);
                $carBrandModel->filters()->create(['notification_id' => $notification->id]);
            }
            if ( $types ) {
                foreach ( $types as $type ) {
                    $carTypeModel = $carTypeRepository->model->find($type);
                    $carTypeModel->filters()->create(['notification_id' => $notification->id]);
                }
            }
        } elseif ( $makes ) {
            foreach ( $makes as $make ) {
                $carMakeModel = $carMakeRepository->model->find($make);
                $carMakeModel->filters()->create(['notification_id' => $notification->id]);
            }
            if ( $types ) {
                foreach ( $types as $type ) {
                    $carTypeModel = $carTypeRepository->model->find($type);
                    $carTypeModel->filters()->create(['notification_id' => $notification->id]);
                }
            }
        }

        return true;
    }


}
