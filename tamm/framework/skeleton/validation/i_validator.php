<?php

namespace Tamm\Framework\Skeleton\Validation;

interface IValidator{
    public function getName() : string;
    public function setValue(string $value, $params = array());
    public function validate() : bool;
}