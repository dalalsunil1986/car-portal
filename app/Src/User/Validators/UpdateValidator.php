<?php namespace App\Src\User\Validators;

use App\Core\BaseValidator;

class UpdateValidator extends BaseValidator
{

    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = array(
        'name'     => 'alpha_num|between:3,20',
        'password' => 'alpha_num|between:6,12|confirmed',
    );

    public function __construct($id)
    {
        parent::__construct();

        $this->id = $id;
    }

    /**
     * Get the prepared input data.
     *
     * @return array
     */
    public function getInputData()
    {
        return array_only($this->inputData, [
            'name',
            'password'
        ]);
    }
}
