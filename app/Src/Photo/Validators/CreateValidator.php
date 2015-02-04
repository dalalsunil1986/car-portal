<?php namespace Kuwaitii\Photo\Validators;

use Kuwaitii\Core\Validators\AbstractValidator;

class CreateValidator extends AbstractValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [
        'imageable_type'=>'required',
        'imageable_id'=>'required | integer'
    ];

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
             'imageable_type','imageable_id','name'
        ]);
    }

}
