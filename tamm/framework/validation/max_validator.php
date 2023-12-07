<?php

namespace Tamm\Framework\Validation;

use Tamm\Framework\Skelton\Validation\IValidator;

class MaxValidator implements IValidator {

    private string $value;
    private int $max;
    
    // public function __construct(string $value, int $max)
    // {
    //     $this->value = $value;
    //     $this->max  = $max;
    // }

    public function getName() : string {
        return "max";
    }

    public function setValue(string $value, $params = array())
    {
        $this->value = $value;
        $this->max = $params[0] ?? 0 ;
    }

    public function validate() : bool {
        if(($this->value !== "") && (strlen($this->value) <= $this->max)){
            return true;
        }
        return false;
    }
}