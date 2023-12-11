<?php

namespace Tamm\Framework\Validation;

use Tamm\Framework\Skeleton\Validation\IValidator;

class RequiredValidator implements IValidator {

    private string $value = "";
    
    // public function __construct(string $value)
    // {
    //     $this->value = $value;
    // }

    public function getName() : string {
        return "required";
    }

    public function setValue(string $value, $params = array())
    {
        $this->value = $value;
        // $this->max = $params[0] ?? 0 ;
    }

    public function validate() : bool {
        if($this->value !== ""){
            return true;
        }
        return false;
    }
}