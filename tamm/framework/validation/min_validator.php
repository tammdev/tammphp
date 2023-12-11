<?php

namespace Tamm\Framework\Validation;

use Tamm\Framework\Skeleton\Validation\IValidator;

class MinValidator implements IValidator {

    private string $value;
    private int $min;
    
    // public function __construct(string $value, int $min)
    // {
    //     $this->value = $value;
    //     $this->min  = $min;
    // }

    public function getName() : string {
        return "min";
    }

    public function setValue(string $value, $params = array())
    {
        $this->value = $value;
        $this->min = $params[0] ?? 0 ;
    }

    public function validate() : bool {
        if(($this->value !== "") && (strlen($this->value) >= $this->min)){
            return true;
        }
        return false;
    }
}