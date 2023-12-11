<?php

namespace Tamm\Framework\Skeleton\Web;

/**
 * Interface IResponseModel
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Web
 */

interface IResponseModel {
    public function getValue(string $key) : object;
    public function setValue(string $key, object $value) : void ;
}