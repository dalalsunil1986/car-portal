<?php
namespace App\Src\Favorite;

use App\Core\BaseRepository;

class DealerRepository extends BaseRepository
{
    public $model;

    public function __construct(Dealer $model)
    {
        $this->model = $model;
    }


}