<?php

namespace Tamm\Framework\Web;

use Tamm\Framework\Skeleton\Web\IRequest;
use Tamm\Framework\Skeleton\Web\IRequestBuilder;
use Tamm\Framework\Web\HttpRequestBuilder;

/**
 * Class HttpRequest
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Web
 */
class HttpRequest implements IRequest
{
    private $method;
    private $host;
    private $port;
    private $uri;
    private $headers;
    private $body;
    private $params;

    // public function __construct($method, $host, $port, $uri, $headers, $body, $params)
    // {
    //     $this->method = $method;
    //     $this->host = $host;
    //     $this->port = $port;
    //     $this->uri = $uri;
    //     $this->headers = $headers;
    //     $this->body = $body;
    //     $this->params = $params;
    // }

    protected function __construct()
    {
        
    }

    public function setMethod($method)
    {
        $this->method = $method;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function setHost($host)
    {
        $this->host = $host;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function setPort($port)
    {
        $this->port = $port;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function setUri($uri)
    {
        $this->uri = $uri;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setParams($params)
    {
        $this->params = $params;
    }

    public function getParams()
    {
        return $this->params;
    }

    public static function builder() : IRequestBuilder
    {
        return new HttpRequestBuilder(new self());
    }
}