<?php
namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Src\Car\Repository\CarRepository;
use App\Src\Favorite\FavoriteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CarController extends Controller
{

    private $carRepository;

    /**
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    public function index()
    {
        return view('module.cars.index');
    }

    public function show($id)
    {
        $car = $this->carRepository->model->with([
            'model.brand',
            'user',
            'thumbnail',
            'photos',
            'favorited'
        ])->find($id);

        return view('module.cars.view', compact('car'));
    }

    /*********************************************************************************************************
     * Api Routes
     ********************************************************************************************************/
    /**
     * Gets Car Asynchronously For Search Filters
     * @param Request $request
     * @param CarRepository $carRepository
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCars(Request $request, CarRepository $carRepository)
    {
        $getMakes = array_filter(explode(',', $request->get('make')));
        $getBrands = array_filter(explode(',', $request->get('brand')));
        $getModels = array_filter(explode(',', $request->get('model')));
        $getTypes = array_filter(explode(',', $request->get('type')));
        $mileageFrom = $request->get('mileage_from');
        $mileageTo = $request->get('mileage_to');
        $priceFrom = $request->get('price_from');
        $priceTo = $request->get('price_to');
        $yearFrom = $request->get('year_from');
        $yearTo = $request->get('year_to');
        $maxPrice = $carRepository::MAXPRICE;
        $maxYear = $carRepository::MAXYEAR;
        $maxMileage = $carRepository::MAXMILEAGE;

        if ($getMakes || $getBrands || $getModels || $getTypes || !(empty($priceFrom)) || !(empty($yearFrom)) || !(empty($mileageFrom))) {

            $cars = $this->carRepository->model->with(['thumbnail', 'favorited'])
                // start querying
                ->where(function ($query) use (
                    $getMakes,
                    $getBrands,
                    $getModels,
                    $getTypes,
                    $mileageFrom,
                    $mileageTo,
                    $priceFrom,
                    $priceTo,
                    $yearFrom,
                    $yearTo,
                    $maxMileage,
                    $maxPrice,
                    $maxYear
                ) {

                    if ($getModels) {
                        $query->whereIn('model_id', $getModels);
                    } elseif ($getBrands) {
                        $query->whereHas('model', function ($query) use ($getBrands) {
                            $query->whereIn('car_models.brand_id', $getBrands);
                        });
                        if ($getTypes) {
                            $query->whereHas('model', function ($query) use ($getTypes) {
                                $query->whereIn('car_models.type_id', $getTypes);
                            });
                        }
                    } elseif ($getMakes) {
                        $query->whereHas('model', function ($query) use ($getMakes) {
                            $query->whereHas('brand', function ($query) use ($getMakes) {
                                $query->whereIn('car_brands.make_id', $getMakes);
                            });
                        });
                        if ($getTypes) {
                            $query->whereHas('model', function ($query) use ($getTypes) {
                                $query->whereIn('car_models.type_id', $getTypes);
                            });
                        }
                    }

                    if ($mileageTo < $maxMileage) {
                        $query->whereBetween('mileage', [$mileageFrom, $mileageTo]);
                    } else {
                        $query->where('mileage', '>', $mileageFrom);
                    }

                    if ($priceTo < $maxPrice) {
                        $query->whereBetween('price', [$priceFrom, $priceTo]);
                    } else {
                        $query->where('price', '>', $priceFrom);
                    }

                    if ($yearTo < $maxYear) {
                        $query->whereBetween('year', [$yearFrom, $yearTo]);
                    } else {
                        $query->where('year', '>', $yearFrom);
                    }

                })
                ->select(['id', 'model_id', 'year', 'mileage', 'price', 'created_at'])
                ->orderBy('id', 'DESC')
                ->paginate(10);
        } else {
            $cars = $this->carRepository->model->with(['thumbnail', 'favorited'])->paginate(10);
        }

        return $cars;
    }


    public function favorite($id, FavoriteRepository $favoriteRepository)
    {
        $car = $this->carRepository->findById($id);

        if ($favoriteRepository->attach($car)) {
            return Response::json(['class' => 'success', 'message' => ['favorited']], 200);
        }
    }

}