<?php

namespace Tamm\Core\Skelton;

use Tamm\Core\Skelton\HttpRequest;

/**
 * Class HttpRequestBuilder
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */

 class HttpRequestBuilder {
    
    private HttpRequest $httpRequest;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    public function withMethod($method)
    {
        $this->httpRequest->setMethod($method);
        return $this;
    }

    public function withHost($host)
    {
        $this->httpRequest->setHost($host);
        return $this;
    }

    public function withPort($port)
    {
        $this->httpRequest->setPort($port);
        return $this;
    }

    public function withUri($uri){
        $this->httpRequest->setUri($uri);
        return $this;
    }

    public function withHeaders($headers)
    {
        $this->httpRequest->setHeaders($headers);
        return $this;
    }

    public function withBody($body)
    {
        $this->httpRequest->setBody($body);
        return $this;
    }

    public function withParams($params)
    {
        $this->httpRequest->setParams($params);
        return $this;
    }

    public function build()
    {
        return $this->httpRequest;
    }
}