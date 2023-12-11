<?php

namespace Tamm\Framework\Skeleton\Web;

/**
 * Interface IRequest
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Web
 */

interface IRequest {
    //
    public function setMethod($method);
    public function setHost($host);
    public function setPort($port);
    public function setUri($uri);
    public function setHeaders($headers);
    public function setBody($body);
    public function setParams($params);
    //
    public function getMethod();
    public function getHost();
    public function getPort();
    public function getUri();
    public function getHeaders();
    public function getBody();
    public function getParams();
    //
    public static function builder() : IRequestBuilder;
}