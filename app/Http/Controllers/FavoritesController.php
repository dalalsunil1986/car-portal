<?php namespace App\Http\Controllers;

use App\Src\Favorite\FavoriteRepository;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;

class FavoritesController extends Controller {

    /**
     * @var FavoriteRepository
     */
    private $favoriteRepository;

    /**
     * @param FavoriteRepository $favoriteRepository
     */
    public function __construct(FavoriteRepository $favoriteRepository)
    {
        $this->favoriteRepository = $favoriteRepository;
    }

    /**
     * @return mixed
     * Find All the Favorites for the user
     */
    public function index()
    {
        $userId    = 1; // Auth::user()->id;
        $favorites = $this->favoriteRepository->findAllForUser($userId);

        return $favorites;
    }


    public function store()
    {
        $userId           = 1; // Auth::user()->id;
        $favoriteableId   = Input::get('favoriteable_id');
        $favoriteableType = Input::get('favoriteable_type');
        $favorite         = $this->favoriteRepository->hasFavorited($userId,$favoriteableId, $favoriteableType);

        if ( !$favorite ) {
            if ( $record = $this->favoriteRepository->create(array_merge(['user_id' => $userId], Input::all())) ) {
                $favorite = $this->favoriteRepository->model->find($record->id);

                return $favorite;
            }
        }
        // If already Favorited
        return Response::make('invalid', 401);
    }

    public function show($id)
    {
        $favorite = $this->favoriteRepository->findById($id);

        return $favorite;
    }

    public function destroy($id)
    {
        $favorite = $this->favoriteRepository->model->find($id);
        $favorite->delete();
    }
}