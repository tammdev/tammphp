<?php

namespace Tamm\Core\Skelton;


/**
 * Class HttpRequest
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class HttpRequest
{
    private $method;
    private $uri;
    private $headers;
    private $body;
    private $params;

    public function __construct($method, $uri, $headers, $body, $params)
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->headers = $headers;
        $this->body = $body;
        $this->params = $params;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function getParams()
    {
        return $this->params;
    }
}