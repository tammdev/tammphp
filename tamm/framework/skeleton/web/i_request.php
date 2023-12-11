<?php

namespace Tamm\Framework\Skeleton\Web;

/**
 * Interface IRequest
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Web
 */

interface IRequest {
    public static function getInstance();
    //
    public function getMethod();
    public function getHost();
    public function getPort();
    public function getUri();
    public function getHeaders();
    public function getBody();
    public function getQueryParams();
    
}