<?php namespace App\Src\Message\Validators;

use App\Core\BaseValidator;

class UpdateValidator extends BaseValidator {

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'body' => 'required',
    );

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'body'
        ]);
    }

}
