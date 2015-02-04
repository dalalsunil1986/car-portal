<?php namespace App\Http\Controllers;

use App\Src\Car\Repository\CarBrandRepository;
use App\Src\Car\Repository\CarMakeRepository;
use App\Src\Car\Repository\CarModelRepository;
use App\Src\Car\CarRepository;
use App\Src\Car\Repository\CarTypeRepository;
use App\Src\Favorite\FavoriteRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Tag\TagRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;

class CarsController extends Controller {

    private $carRepository;

    private $carMakeRepository;

    private $carBrandRepository;

    private $carModelRepository;

    private $carTypeRepository;

    private $tagRepository;

    private $photoRepository;

    /**
     * @param CarRepository $carRepository
     * @param CarMakeRepository $carMakeRepository
     * @param CarBrandRepository $carBrandRepository
     * @param CarModelRepository $carModelRepository
     * @param CarTypeRepository $carTypeRepository
     * @param TagRepository $tagRepository
     * @param PhotoRepository $photoRepository
     */
    public function __construct(CarRepository $carRepository, CarMakeRepository $carMakeRepository, CarBrandRepository $carBrandRepository, CarModelRepository $carModelRepository, CarTypeRepository $carTypeRepository, TagRepository $tagRepository, PhotoRepository $photoRepository)
    {
        $this->carRepository      = $carRepository;
        $this->carMakeRepository  = $carMakeRepository;
        $this->carBrandRepository = $carBrandRepository;
        $this->carModelRepository = $carModelRepository;
        $this->carTypeRepository  = $carTypeRepository;
        $this->tagRepository      = $tagRepository;
        $this->photoRepository    = $photoRepository;
    }

    public function index()
    {
        return view('module.cars.index');
    }


    public function show($id)
    {
        $car = $this->carRepository->model->with(['model.brand', 'user'])->find($id);

        return view('module.cars.view', compact('car'));
    }

    public function create()
    {
        $models = ['' => ''] + $this->carModelRepository->model->get()->lists('name', 'id');
        $tags   = $this->tagRepository->model->get()->lists('name', 'id');

        return view('module.cars.create', compact('models', 'tags'));
    }

    /**
     * @return mixed
     * @throws \Exception
     * @internal param PostCarRequest $request
     */
    public function store()
    {
        $val    = $this->carRepository->getCreateForm();
        $userId = 1; // todo: replace with Auth::user()->id;

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $car = $this->carRepository->create(array_merge(['user_id' => $userId], $val->getInputData()));

        if ( $car ) {
            // upload the file to the server

            $upload = $this->photoRepository->attach(Input::file('thumbnail'), $car, ['thumbnail' => 1]);

            if ( !$upload ) {

                $car->delete();

                return Redirect::back()->with('errors', ['Could Not upload the photo, try again'])->withInput();
            }

            // save the file in the db
            $tags = is_array(Input::get('tags')) ? Input::get('tags') : [];
            $this->tagRepository->attach($car, $tags);
        }

        return Redirect::action('CarsController@edit', [$car->id, '#optionals'])->with('success', 'Saved');
    }

    public function edit($id)
    {
        $car          = $this->carRepository->model->find($id);
        $tags         = $this->tagRepository->model->get()->lists('name', 'id');
        $attachedTags = ['' => ''] + $car->tags->lists('name', 'id');
        $models       = $this->carModelRepository->model->get()->lists('name', 'id');

        return view('module.cars.edit', compact('car', 'tags', 'attachedTags', 'models'));
    }

    public function update($id)
    {
        $val    = $this->carRepository->getEditForm($id);
        $userId = 1; // todo: replace with Auth::user()->id;

        if ( !$val->isValid() ) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $car = $this->carRepository->update($id, array_merge(['user_id' => $userId], $val->getInputData()));

        if ( $car ) {

            if ( Input::hasFile('thumbnail') ) {
                // upload the file to the server
                $upload = $this->photoRepository->replace(Input::file('thumbnail'), $car, ['thumbnail' => 1], $id);

                if ( !$upload ) {

                    $car->delete();

                    return Redirect::back()->with('errors', ['Could Not upload photo, try again'])->withInput();
                }
            }

            if ( Input::hasFile('photos') && is_array(Input::file('photos')) ) {
                foreach ( Input::file('photos') as $photo ) {
                    $this->photoRepository->attach($photo, $car);
                }
            }

            // save the file in the db
            $tags = is_array(Input::get('tags')) ? Input::get('tags') : [];
            $this->tagRepository->attach($car, $tags);
        }

        return Redirect::action('CarsController@show', $car->id)->with('success', 'Saved');

    }

    /*********************************************************************************************************
     * Api Routes
     ********************************************************************************************************/
    /**
     * Gets Car Asynchronously For Search Filters
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCars()
    {
        $getMakes    = Input::get('make') ? Input::get('make') : '';
        $getBrands   = Input::get('brand') ? Input::get('brand') : '';
        $getModels   = Input::get('model') ? Input::get('model') : '';
        $getTypes    = Input::get('type') ? Input::get('type') : '';
        $mileageFrom = Input::get('mileage-from');
        $mileageTo   = Input::get('mileage-to');
        $priceFrom   = Input::get('price-from');
        $priceTo     = Input::get('price-to');
        $yearFrom    = Input::get('year-from');
        $yearTo      = Input::get('year-to');

        if ( !(empty($getMakes)) || !(empty($getBrands)) || !(empty($getModels)) || !(empty($getTypes)) || !(empty($priceFrom)) || !(empty($yearFrom)) || !(empty($mileageFrom)) ) {

            $makeArray  = array_filter(explode(',', $getMakes));
            $brandArray = array_filter(explode(',', $getBrands));
            $modelArray = array_filter(explode(',', $getModels));
            $typeArray  = array_filter(explode(',', $getTypes));

            $cars = $this->carRepository->model->with(['thumbnail'])
                // start querying
                ->where(function ($query) use ($makeArray, $brandArray, $modelArray, $typeArray, $mileageFrom, $mileageTo, $priceFrom, $priceTo, $yearFrom, $yearTo) {
                    if ( count($makeArray) ) {
                        $query->whereHas('model', function ($query) use ($makeArray) {
                            $query->whereHas('brand', function ($query) use ($makeArray) {
                                $query->whereIn('car_brands.make_id', $makeArray);
                            });
                        });
                    }

                    if ( count($brandArray) ) {
                        $query->whereHas('model', function ($query) use ($brandArray) {
                            $query->whereIn('car_models.brand_id', $brandArray);
                        });
                    }

                    if ( count($modelArray) ) {
                        $query->whereIn('model_id', $modelArray);
                    }

                    if ( count($typeArray) ) {
                        $query->whereHas('model', function ($query) use ($typeArray) {
                            $query->whereIn('car_models.type_id', $typeArray);
                        });
                    }

                    if ( $mileageFrom ) {
                        $query->where('mileage', '>', $mileageFrom)->where('mileage', '<', $mileageTo);
                    }

                    if ( $priceFrom ) {
                        $query->where('price', '>', $priceFrom)->where('price', '<', $priceTo);
                    }

                    if ( $yearFrom ) {
                        $query->where('year', '>', $yearFrom)->where('year', '<', $yearTo);
                    }

                })->paginate(10);
        } else {
            $cars = $this->carRepository->model->with(['thumbnail'])->paginate(10);
        }

        return $cars;
    }

    /**
     * Find Data's For Car Filter
     */
    public function filter()
    {
        // get the inputs and make it an array
        $getMakes  = array_filter(explode(',', Input::get('make')));
        $getBrands = array_filter(explode(',', Input::get('brand')));
        $getModels = array_filter(explode(',', Input::get('model')));
        $getTypes  = array_filter(explode(',', Input::get('type')));

        // Get the Car Filter Initial Values From the Database
        $makes  = $this->carMakeRepository->getNames();
        $brands = $this->carBrandRepository->getNames();
        $models = $this->carModelRepository->getNames();
        $types  = $this->carTypeRepository->getNames();

        if ( $getMakes ) {
            // find the brands
            $brands = $this->carBrandRepository->model
                ->whereIn('make_id', $getMakes)
                ->get(['id', 'name_en as name']);

            // find the models
            if ( !$getBrands ) {
                // If Type is in the GET Request
                if ( $getTypes ) {

                    // Fetch the Models For Make ID
                    $models = $this->carModelRepository->model
                        ->whereHas('brand', function ($query) use ($getMakes, $getTypes) {
                            $query->whereIn('car_brands.make_id', $getMakes)->whereIn('type_id', $getTypes);
                        })->get(['id', 'name_en as name']);

                } else {

                    // Just Get the Models For Make ID
                    $models = $this->carModelRepository->model
                        ->whereHas('brand', function ($query) use ($getMakes) {
                            $query->whereIn('car_brands.make_id', $getMakes);
                        })->get(['id', 'name_en as name']);
                }
            }

            // 1- First Get All the ID's
            $makesArray = $makes->modelKeys();

            // Find the ID's that are not in the GET Request
            $makesNotInGET = array_diff($makesArray, $getMakes);

            if ( count($makesNotInGET) ) {
                $makes = $this->carMakeRepository->model->whereIn('id', $makesNotInGET)->get(['id', 'name_en as name']);
            } else {
                $makes = [];
            }
        }

        if ( $getBrands ) {

            // If Type is in GET Request
            if ( $getTypes ) {

                // Fetch the Models for type Where Has the Brand ID and Type Id
                $models = $this->carModelRepository->model->whereIn('brand_id', $getBrands)
                    ->whereIn('type_id', $getTypes)
                    ->get(['id', 'name_en as name']);

            } else {

                // Fetch the Models for type Where Has the Brand ID only
                $models = $this->carModelRepository->model
                    ->whereIn('brand_id', $getBrands)
                    ->get(['id', 'name_en as name']);
            }

            $brandsArray = $brands->modelKeys(); // Get the ID

            // Remove Unnecessary Brands From Selected Elements
            foreach ( $getBrands as $key => $value ) {
                if ( !in_array($value, $brandsArray) ) {
                    unset($getBrands[$key]);
                }
            }

            // pass the array only that's value is not the in GET REQUEST
            $brandsNotInGET = array_diff($brandsArray, $getBrands);

            if ( count($brandsNotInGET) ) {

                // If there are any brands left in the DB that are not in the GET Request, Then fetch it.
                $brands = $this->carBrandRepository->model->whereIn('id', $brandsNotInGET)->get(['id', 'name_en as name']);
            } else {
                // pass an empty string, so that no option will be showed to select in the front end select2 element
                $brands = [];
            }

        }

        if ( $getTypes ) {

            if ( !$getMakes && !$getBrands ) {

                $models = $this->carModelRepository->model
                    ->whereIn('type_id', $getTypes)
                    ->get(['id', 'name_en as name']);

            }
            // Remove unncessary type values from the GET array
            $typesArray = $types->modelKeys();

            foreach ( $getTypes as $key => $value ) {

                if ( !in_array($value, $typesArray) ) {
                    unset($typesArray[$key]);
                }
            }

            $typesNotInGET = array_diff($typesArray, $getTypes);

            if ( count($typesNotInGET) ) {

                $types = $this->carTypeRepository->model->whereIn('id', $typesNotInGET)->get(['id', 'name_en as name']);
            } else {

                $types = [];
            }

        }

        if ( $getModels ) {

            $modelsArray = $models->modelKeys();

            foreach ( $getModels as $key => $value ) {
                if ( !in_array($value, $modelsArray) ) {
                    unset($getModels[$key]);
                }
            }
            $modelsNotInGET = array_diff($modelsArray, $getModels);

            if ( count($modelsNotInGET) ) {

                $models = $this->carModelRepository->model->whereIn('id', $modelsNotInGET)->get(['id', 'name_en as name']);
            } else {
                $models = [];
            }

        }

        // Cast the Array values into Int, so that it matches with the selected value and avoid duplicate queries
        array_walk($getBrands, function (&$item) {
            $item = (int) $item;
        });
        array_walk($getModels, function (&$item) {
            $item = (int) $item;
        });

        $return = [
            'results' => [
                'makes'       => $makes,
                'brands'      => $brands,
                'types'       => $types,
                'models'      => $models,
                'brandsArray' => array_values(array_unique($getBrands)),
                'modelsArray' => array_values(array_unique($getModels))
            ]
        ];

        return $return;
    }

    public function favorite($id, FavoriteRepository $favoriteRepository)
    {
        $car = $this->carRepository->findById($id);

        if ( $favoriteRepository->attach($car) ) {
            return Response::make(array('class' => 'success', 'message' => ['favorited']), 200);
        }
    }

    public function getNotify(){
        // get the inputs and make it an array
        $getMakes  = array_filter(explode(',', Input::get('make')));
        $getBrands = array_filter(explode(',', Input::get('brand')));
        $getModels = array_filter(explode(',', Input::get('model')));
        $getTypes  = array_filter(explode(',', Input::get('type')));

        $makes=  empty($getMakes) ? '' : $this->carMakeRepository->getNames($getMakes);
        $brands=  empty($getBrands) ? '' : $this->carBrandRepository->getNames($getBrands);
        $models=  empty($getModels) ? '' : $this->carModelRepository->getNames($getModels);
        $types=  empty($getTypes) ? '' : $this->carTypeRepository->getNames($getTypes);

        return $return = [
            'results' => [
                'makes'       => $makes,
                'brands'      => $brands,
                'types'       => $types,
                'models'      => $models
            ]
        ];

    }

}