<?php

namespace Tamm\Core\Validation;

interface IValidator{
    public function getName() : string;
    public function validate() : bool;
}