<?php namespace App\Src\Car\Validators;

use App\Core\BaseValidator;

class UpdateValidator extends BaseValidator
{

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'model_id'  => 'integer',
        'year'      => 'integer',
        'mileage'   => 'integer',
        'price'     => 'integer',
        'phone'     => 'integer',
        'thumbnail' => 'image',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'model_id',
            'year',
            'mileage',
            'price',
            'phone',
            'thumbnail',
            'description',
            'latitude',
            'longitude'
        ]);
    }

    /**
     * unset thumbnail after the validation, to avoid sending the data in create method
     */
    public function afterValidation()
    {
        unset($this->inputData['thumbnail']);
    }
}
