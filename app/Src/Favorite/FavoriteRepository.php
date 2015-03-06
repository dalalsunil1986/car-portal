<?php
namespace App\Src\Favorite;

use App\Core\BaseRepository;
use App\Core\CrudableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use ReflectionClass;

class FavoriteRepository extends BaseRepository
{

    use CrudableTrait;
    public $model;

    public function __construct(Favorite $model)
    {
        $this->model = $model;

        parent::__construct(new MessageBag);
    }

    public function findAllForUser($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    /**
     * @param $getModel
     * @return bool
     */
    public function attach(Model $getModel)
    {
        $class = new ReflectionClass($getModel);
        //  $userId = Auth::user()->id;
        $userId           = 1;
        $favoriteableId   = $getModel->id;
        $favoriteableType = $class->getShortName();

        $fav = $this->model->where('user_id', $userId)->where('favoriteable_id',
            $favoriteableId)->where('favoriteable_type', $favoriteableType)->first();

        if (!$fav) {
            $this->model->create([
                'user_id'           => $userId,
                'favoriteable_id'   => $favoriteableId,
                'favoriteable_type' => $favoriteableType
            ]);
        }

        return true;
    }

    public function hasFavorited($userId, $typeId, $type)
    {
        return $this->model->where('user_id', $userId)->where('favoriteable_id', $typeId)->where('favoriteable_type',
            $type)->first();
    }

}