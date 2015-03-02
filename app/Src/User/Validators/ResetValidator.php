<?php namespace App\Src\User\Validators;

use App\Core\BaseValidator;

class ResetValidator extends BaseValidator
{

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email' => 'required|email',
    );

}
