<?php
namespace App\Http\Controllers\Car;

use App\Http\Controllers\Controller;
use App\Src\Car\Repository\CarRepository;
use App\Src\Car\Repository\CarBrandRepository;
use App\Src\Car\Repository\CarMakeRepository;
use App\Src\Car\Repository\CarModelRepository;
use App\Src\Car\Repository\CarTypeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CarSearchController extends Controller
{

    private $carRepository;

    /**
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
    }

    /**
     * @param Request $request
     * @param CarMakeRepository $carMakeRepository
     * @param CarBrandRepository $carBrandRepository
     * @param CarTypeRepository $carTypeRepository
     * @param CarModelRepository $carModelRepository
     * @return mixed
     */
    public function search(
        Request $request,
        CarMakeRepository $carMakeRepository,
        CarBrandRepository $carBrandRepository,
        CarTypeRepository $carTypeRepository,
        CarModelRepository $carModelRepository
    ) {
        // get the inputs and make it an array
        $getMakes = array_filter(explode(',', $request->get('make')));
        $getBrands = array_filter(explode(',', $request->get('brand')));
        $getModels = array_filter(explode(',', $request->get('model')));
        $getTypes = array_filter(explode(',', $request->get('type')));

        // Get the Car Filter Initial Values From the Database
        $makes = $carMakeRepository->getNames();
        $brands = $carBrandRepository->getNames();
        $models = $carModelRepository->getNames();
        $types = $carTypeRepository->getNames();

        if ($getMakes) {
            // find the brands
            $brands = $carBrandRepository->model
                ->whereIn('make_id', $getMakes)
                ->get(['id', 'name_en as name']);

            // find the models
            if (!$getBrands) {
                // If Type is in the GET Request
                if ($getTypes) {

                    // Fetch the Models For Make ID
                    $models = $carModelRepository->model
                        ->whereHas('brand', function ($query) use ($getMakes, $getTypes) {
                            $query->whereIn('car_brands.make_id', $getMakes)->whereIn('type_id', $getTypes);
                        })->get(['id', 'name_en as name']);

                } else {

                    // Just Get the Models For Make ID
                    $models = $carModelRepository->model
                        ->whereHas('brand', function ($query) use ($getMakes) {
                            $query->whereIn('car_brands.make_id', $getMakes);
                        })->get(['id', 'name_en as name']);
                }
            }

            // 1- First Get All the ID's
            $makesArray = $makes->modelKeys();

            // Find the ID's that are not in the GET Request
            $makesNotInGET = array_diff($makesArray, $getMakes);

            if (count($makesNotInGET)) {
                $makes = $carMakeRepository->model->whereIn('id', $makesNotInGET)->get(['id', 'name_en as name']);
            } else {
                $makes = [];
            }
        }

        if ($getBrands) {

            // If Type is in GET Request
            if ($getTypes) {

                // Fetch the Models for type Where Has the Brand ID and Type Id
                $models = $carModelRepository->model->whereIn('brand_id', $getBrands)
                    ->whereIn('type_id', $getTypes)
                    ->get(['id', 'name_en as name']);

            } else {

                // Fetch the Models for type Where Has the Brand ID only
                $models = $carModelRepository->model
                    ->whereIn('brand_id', $getBrands)
                    ->get(['id', 'name_en as name']);
            }

            $brandsArray = $brands->modelKeys(); // Get the ID

            // Remove Unnecessary Brands From Selected Elements
            foreach ($getBrands as $key => $value) {
                if (!in_array($value, $brandsArray)) {
                    unset($getBrands[$key]);
                }
            }

            // pass the array only that's value is not the in GET REQUEST
            $brandsNotInGET = array_diff($brandsArray, $getBrands);

            if (count($brandsNotInGET)) {

                // If there are any brands left in the DB that are not in the GET Request, Then fetch it.
                $brands = $carBrandRepository->model->whereIn('id', $brandsNotInGET)->get(['id', 'name_en as name']);
            } else {
                // pass an empty string, so that no option will be showed to select in the front end select2 element
                $brands = [];
            }

        }

        if ($getTypes) {

            if (!$getMakes && !$getBrands) {

                $models = $carModelRepository->model
                    ->whereIn('type_id', $getTypes)
                    ->get(['id', 'name_en as name']);

            }
            // Remove unncessary type values from the GET array
            $typesArray = $types->modelKeys();

            foreach ($getTypes as $key => $value) {

                if (!in_array($value, $typesArray)) {
                    unset($typesArray[$key]);
                }
            }

            $typesNotInGET = array_diff($typesArray, $getTypes);

            if (count($typesNotInGET)) {

                $types = $carTypeRepository->model->whereIn('id', $typesNotInGET)->get(['id', 'name_en as name']);
            } else {

                $types = [];
            }

        }

        if ($getModels) {

            $modelsArray = $models->modelKeys();

            foreach ($getModels as $key => $value) {
                if (!in_array($value, $modelsArray)) {
                    unset($getModels[$key]);
                }
            }
            $modelsNotInGET = array_diff($modelsArray, $getModels);

            if (count($modelsNotInGET)) {

                $models = $carModelRepository->model->whereIn('id', $modelsNotInGET)->get(['id', 'name_en as name']);
            } else {
                $models = [];
            }

        }

        // Cast the Array values into Int, so that it matches with the selected value and avoid duplicate queries
        array_walk($getBrands, function (&$item) {
            $item = (int)$item;
        });
        array_walk($getModels, function (&$item) {
            $item = (int)$item;
        });

        $return = Response::json([
            'results' => [
                'makes'       => $makes,
                'brands'      => $brands,
                'types'       => $types,
                'models'      => $models,
                'brandsArray' => array_values(array_unique($getBrands)),
                'modelsArray' => array_values(array_unique($getModels))
            ]
        ]);

        return $return;
    }

    /**
     * @param CarMakeRepository $carMakeRepository
     * @param CarBrandRepository $carBrandRepository
     * @param CarTypeRepository $carTypeRepository
     * @param CarModelRepository $carModelRepository
     * @return array
     */
    public function getFilterNames(
        Request $request,
        CarMakeRepository $carMakeRepository,
        CarBrandRepository $carBrandRepository,
        CarTypeRepository $carTypeRepository,
        CarModelRepository $carModelRepository
    ) {
        // get the inputs and make it an array
        $getMakes = array_filter(explode(',', $request->get('make')));
        $getBrands = array_filter(explode(',', $request->get('brand')));
        $getModels = array_filter(explode(',', $request->get('model')));
        $getTypes = array_filter(explode(',', $request->get('type')));

        $makes = empty($getMakes) ? '' : $carMakeRepository->getNames($getMakes);
        $brands = empty($getBrands) ? '' : $carBrandRepository->getNames($getBrands);
        $models = empty($getModels) ? '' : $carModelRepository->getNames($getModels);
        $types = empty($getTypes) ? '' : $carTypeRepository->getNames($getTypes);

        return $return = [
            'results' => [
                'makes'  => $makes,
                'brands' => $brands,
                'types'  => $types,
                'models' => $models
            ]
        ];

    }

}