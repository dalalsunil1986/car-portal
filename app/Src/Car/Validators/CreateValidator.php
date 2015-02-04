<?php namespace App\Src\Car\Validators;

use App\Core\BaseValidator;

class CreateValidator extends BaseValidator  {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'model_id' => 'integer|required',
        'year' => 'integer|required',
        'mileage' => 'integer|required',
        'price' => 'integer|required',
        'mobile' => 'integer|required',
        'thumbnail' => 'required | image',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'model_id','year','mileage','price','mobile','thumbnail'
        ]);
    }

    /**
     * unset thumbnail after the validation, to avoid sending the data in create method
     */
    public function afterValidation(){
         unset($this->inputData['thumbnail']);
    }

}
