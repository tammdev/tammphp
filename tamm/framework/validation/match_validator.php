<?php

namespace Tamm\Framework\Validation;

use Tamm\Framework\Skeleton\Validation\IValidator;

class MatchValidator implements IValidator {

    private string $value;
    private string $match;
    
    // public function __construct(string $value, string $match)
    // {
    //     $this->value = $value;
    //     $this->match  = $match;
    // }
    public function getName() : string {
        return "match";
    }

    public function setValue(string $value, $params = array())
    {
        $this->value = $value;
        $this->match = $params[0] ?? "";
    }

    public function validate() : bool {
        if(($this->value !== "") && ($this->value === $this->match)){
            return true;
        }
        return false;
    }
}