<?php

namespace Tamm\Framework\Skeleton\Web;

/**
 * Interface IRequestModel
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Web
 */

interface IRequestModelHandler extends IRequestModel {
    public function getValue(string $key) : object;
    public function setValue(string $key, object $value) : void ;
}