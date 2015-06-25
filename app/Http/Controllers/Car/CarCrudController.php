<?php
namespace App\Http\Controllers\Car;

use App\Events\CarWasPosted;
use App\Http\Controllers\Controller;
use App\Src\Car\Repository\CarModelRepository;
use App\Src\Car\Repository\CarRepository;
use App\Src\Photo\PhotoRepository;
use App\Src\Tag\TagRepository;
use Illuminate\Http\Request;

class CarCrudController extends Controller
{

    private $carRepository;

    /**
     * @param CarRepository $carRepository
     */
    public function __construct(CarRepository $carRepository)
    {
        $this->carRepository = $carRepository;
        auth()->loginUsingId(1);
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
        $this->validate($request, [
            'model_id'  => 'integer|required',
            'year'      => 'integer|required',
            'mileage'   => 'integer|required',
            'price'     => 'integer|required',
            'mobile'    => 'integer|required',
            'thumbnail' => 'required|image',
        ]);

        $user = auth()->user();

        $car = $this->carRepository->create(array_merge(['user_id' => $user->id], $request->all()));

        if ($car) {

            // upload the file to the server
            $upload = $photoRepository->attach($request->file('thumbnail'), $car, ['thumbnail' => 1]);

            if (!$upload) {

                $car->delete();

                return redirect()->back()->with('errors', ['Could Not upload the photo, try again'])->withInput();
            }

            // save the file in the db
            $tags = is_array($request->get('tags')) ? $request->get('tags') : [];
            if (!(empty($tags))) {
                $tagRepository->attach($car, $tags);
            }

            // fire notify user filter event
            event(new CarWasPosted($car, auth()->user(), $request, $this->carRepository));

        }

        return redirect()->action('CarsController@edit', [$car->id, '#optionals'])->with('success', 'Saved');
    }

    public function edit($id, CarModelRepository $carModelRepository, TagRepository $tagRepository)
    {
        $car = $this->carRepository->model->find($id);
        $tags = $tagRepository->model->get()->lists('name_en', 'id');
        $models = $carModelRepository->model->get()->lists('name_en', 'id');
        $attachedTags = ['' => ''] + $car->tags->lists('name_en', 'id');

        return view('module.cars.edit', compact('car', 'tags', 'attachedTags', 'models'));
    }

    public function update(Request $request, PhotoRepository $photoRepository, TagRepository $tagRepository, $id)
    {
        $val = $this->carRepository->getEditForm($id);
        $userId = auth()->user()->id; // todo: replace with auth()->user()->id;

        if (!$val->isValid()) {

            return redirect()->back()->with('errors', $val->getErrors())->withInput();
        }

        $car = $this->carRepository->update($id, array_merge(['user_id' => $userId], $val->getInputData()));

        if ($car) {

            if ($request->hasFile('thumbnail')) {
                // upload the file to the server
                $upload = $photoRepository->replace($request->file('thumbnail'), $car, ['thumbnail' => 1], $id);

                if (!$upload) {

                    $car->delete();

                    return redirect()->back()->with('errors', ['Could Not upload photo, try again'])->withInput();
                }
            }

            if ($request->hasFile('photos') && is_array($request->file('photos'))) {
                foreach ($request->file('photos') as $photo) {
                    $photoRepository->attach($photo, $car);
                }
            }

            // save the file in the db
            $tags = is_array($request->get('tags')) ? $request->get('tags') : [];

            if (!(empty($tags))) {
                $tagRepository->attach($car, $tags);
            }
        }

        return redirect()->action('CarsController@show', $car->id)->with('success', 'Saved');

    }

}