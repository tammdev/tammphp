<?php

namespace Tamm\Framework\Validation;

use Tamm\Framework\Skeleton\Validation\IValidator;

class EmailValidator implements IValidator {

    private string $value = "";
    
    // public function __construct(string $value)
    // {
    //     $this->value = $value;
    // }

    public function getName() : string {
        return "email";
    }

    public function setValue(string $value, $params = array())
    {
        $this->value = $value;
    }

    public function validate() : bool {
        if(filter_var($this->value, FILTER_VALIDATE_EMAIL)){
            return true;
        }
        return false;
    }
}