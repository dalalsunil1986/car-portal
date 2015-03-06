<?php
namespace App\Src\User\Validators;

use App\Core\BaseValidator;

class CreateValidator extends BaseValidator
{

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'email'    => 'required|email|unique:users,email',
        'password' => 'required|alpha_num|between:6,12|confirmed',
        'name'     => 'required'
    );


    /**
     * Remove Password field if empty
     */
    public function afterValidation()
    {
        if (!empty($this->inputData['password_confirmation'])) {
            unset($this->inputData['password_confirmation']);
        }

    }
}
