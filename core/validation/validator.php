<?php

namespace Tamm\Core\Validation;

interface Validator{
    public function getName() : string;
    public function validate() : bool;
}