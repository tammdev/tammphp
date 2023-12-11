<?php


namespace Tamm\Framework\Web;


use Tamm\Framework\Skeleton\Web\IRequestModelHandler;

/**
 * Class HttpRequestModel
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Web
 */

class HttpRequestModel implements IRequestModelHandler {
    private $data = [];

    public function getValue(string $key): object {
        if (isset($this->data[$key])) {
            return $this->data[$key];
        } else {
            // throw new \Exception("Value not found for key: $key");
        }
    }

    public function setValue(string $key, object $value): void {
        $this->data[$key] = $value;
    }
}