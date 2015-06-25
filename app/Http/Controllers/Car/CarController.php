<?php
namespace App\Http\Controllers\Car;

use App\Events\CarWasPosted;
use App\Http\Controllers\Controller;
use App\Src\Car\Repository\CarModelRepository;
use App\Src\Car\Repository\CarRepository;
use App\Src\Favorite\FavoriteRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Tag\TagRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
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

    /**
     * @param CarModelRepository $carModelRepository
     * @param TagRepository $tagRepository
     * @return \Illuminate\View\View
     */
    public function create(CarModelRepository $carModelRepository, TagRepository $tagRepository)
    {

        $models = ['' => ''] + $carModelRepository->model->get()->lists('name_en', 'id');
        $tags = $tagRepository->model->get()->lists('name', 'id');

        return view('module.cars.create', compact('models', 'tags'));
    }

    /**
     * @param PhotoRepository $photoRepository
     * @param TagRepository $tagRepository
     * @param Request $request
     * @return mixed
     * @throws \Exception
     * @internal param PostCarRequest $request
     */
    public function store(PhotoRepository $photoRepository, TagRepository $tagRepository, Request $request)
    {
        $val = $this->carRepository->getCreateForm();
        $user = Auth::user(); // todo: replace with Auth::user();

        if (!$val->isValid()) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $car = $this->carRepository->create(array_merge(['user_id' => $user->id], $val->getInputData()));

        if ($car) {
            // upload the file to the server

            $upload = $photoRepository->attach(Input::file('thumbnail'), $car, ['thumbnail' => 1]);

            if (!$upload) {

                $car->delete();

                return Redirect::back()->with('errors', ['Could Not upload the photo, try again'])->withInput();
            }

            // save the file in the db
            $tags = is_array(Input::get('tags')) ? Input::get('tags') : [];
            if (!(empty($tags))) {
                $tagRepository->attach($car, $tags);
            }

            // fire notify user filter event
            Event::fire(new CarWasPosted($car, Auth::user(), $request, $this->carRepository));

        }

        return Redirect::action('CarsController@edit', [$car->id, '#optionals'])->with('success', 'Saved');
    }

    public function edit($id, CarModelRepository $carModelRepository, TagRepository $tagRepository)
    {
        $car = $this->carRepository->model->find($id);
        $tags = $tagRepository->model->get()->lists('name_en', 'id');
        $models = $carModelRepository->model->get()->lists('name_en', 'id');
        $attachedTags = ['' => ''] + $car->tags->lists('name_en', 'id');

        return view('module.cars.edit', compact('car', 'tags', 'attachedTags', 'models'));
    }

    public function update($id, PhotoRepository $photoRepository, TagRepository $tagRepository)
    {
        $val = $this->carRepository->getEditForm($id);
        $userId = Auth::user()->id; // todo: replace with Auth::user()->id;

        if (!$val->isValid()) {

            return Redirect::back()->with('errors', $val->getErrors())->withInput();
        }

        $car = $this->carRepository->update($id, array_merge(['user_id' => $userId], $val->getInputData()));

        if ($car) {

            if (Input::hasFile('thumbnail')) {
                // upload the file to the server
                $upload = $photoRepository->replace(Input::file('thumbnail'), $car, ['thumbnail' => 1], $id);

                if (!$upload) {

                    $car->delete();

                    return Redirect::back()->with('errors', ['Could Not upload photo, try again'])->withInput();
                }
            }

            if (Input::hasFile('photos') && is_array(Input::file('photos'))) {
                foreach (Input::file('photos') as $photo) {
                    $photoRepository->attach($photo, $car);
                }
            }

            // save the file in the db
            $tags = is_array(Input::get('tags')) ? Input::get('tags') : [];

            if (!(empty($tags))) {
                $tagRepository->attach($car, $tags);
            }
        }

        return Redirect::action('CarsController@show', $car->id)->with('success', 'Saved');

    }

    /*********************************************************************************************************
     * Api Routes
     ********************************************************************************************************/
    /**
     * Gets Car Asynchronously For Search Filters
     * @param CarRepository $carRepository
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getCars(CarRepository $carRepository)
    {
        $getMakes = array_filter(explode(',', Input::get('make')));
        $getBrands = array_filter(explode(',', Input::get('brand')));
        $getModels = array_filter(explode(',', Input::get('model')));
        $getTypes = array_filter(explode(',', Input::get('type')));
        $mileageFrom = Input::get('mileage_from');
        $mileageTo = Input::get('mileage_to');
        $priceFrom = Input::get('price_from');
        $priceTo = Input::get('price_to');
        $yearFrom = Input::get('year_from');
        $yearTo = Input::get('year_to');
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
            return Response::make(array('class' => 'success', 'message' => ['favorited']), 200);
        }
    }

}