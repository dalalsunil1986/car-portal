<?php namespace App\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use StdClass;
use Illuminate\Support\MessageBag;

abstract class BaseRepository {

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * @var \Illuminate\Support\MessageBag
     */
    protected $messageBag;

    /**
     * Construct
     *
     * @param \Illuminate\Support\MessageBag $errors
     */
    public function __construct(MessageBag $errors)
    {
        $this->messageBag = $errors;
    }

    /**
     * Return the errors
     *
     * @return \Illuminate\Support\MessageBag
     */
    public function errors()
    {
        return $this->messageBag;
    }

    public function getArrayMessages()
    {
        return array_flatten($this->messageBag->getMessages());
    }

    /**
     * Set error message bag
     *
     * @var \Illuminate\Support\MessageBag
     * @return \Illuminate\Support\MessageBag
     */
    public function addError($errorMsg)
    {
        //@todo enhance snake_case to remove spaces
        $key = snake_case($errorMsg);

        return $this->messageBag->add($key, $errorMsg);
    }

    /**
     * @return string
     */
    public function generateToken()
    {
        return md5(uniqid(mt_rand(), true));
    }

    protected function storeEloquentModel($model)
    {
        if ( $model->getDirty() ) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    protected function storeArray($data)
    {
        $model = $this->getNew($data);

        return $this->storeEloquentModel($model);
    }

    public function save(Model $model)
    {
        if ( $model->getDirty() ) {
            return $model->save();
        } else {
            return $model->touch();
        }
    }

    /**
     * @return namespaced class path
     * Initiatialize the class path for validation
     */
    public function getValidatorClass()
    {
        $calledClass = new \ReflectionClass($this);
        $baseClass   = $this->filterClassName($calledClass->getShortName());
        $fullPath    = 'App\\Src\\' . $baseClass . '\\Validators\\';

        return $fullPath;
    }

    /**
     * Remove Repository Word From the param
     */
    public function filterClassName($className)
    {
        return str_replace('Repository', '', $className);
    }

    /**
     * @param null $array
     * @return mixed Get Localed Name
     * Get Localed Name
     */
    public function getNames($array = null)
    {
        if ( !empty($array) ) {
            $data = $this->model->whereIn('id',$array)->get(['id', 'name_' . App::getLocale() . ' as name']);
        } else {
            $data = $this->model->get(['id', 'name_' . App::getLocale() . ' as name']);
        }

        return $data;
    }

    public function getClassShortName(Model $model)
    {
        $model          = new \ReflectionClass($model);
        $classShortName = $model->getShortName();

        return $classShortName;
    }

}
