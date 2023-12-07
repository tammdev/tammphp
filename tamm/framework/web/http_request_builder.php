<?php

namespace Tamm\Framework\Web;

use Tamm\Framework\Skelton\Web\IRequest;
use Tamm\Framework\Skelton\Web\IRequestBuilder;
use Tamm\Framework\Web\HttpRequest;

/**
 * Class HttpRequestBuilder
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skelton
 */

 class HttpRequestBuilder implements IRequestBuilder 
 {
    
    private IRequest $httpRequest;

    public function __construct(HttpRequest $httpRequest)
    {
        $this->httpRequest = $httpRequest;
    }

    public function withMethod($method) : IRequestBuilder
    {
        $this->httpRequest->setMethod($method);
        return $this;
    }

    public function withHost($host) : IRequestBuilder
    {
        $this->httpRequest->setHost($host);
        return $this;
    }

    public function withPort($port) : IRequestBuilder
    {
        $this->httpRequest->setPort($port);
        return $this;
    }

    public function withUri($uri) : IRequestBuilder
    {
        $this->httpRequest->setUri($uri);
        return $this;
    }

    public function withHeaders($headers) : IRequestBuilder
    {
        $this->httpRequest->setHeaders($headers);
        return $this;
    }

    public function withBody($body) : IRequestBuilder
    {
        $this->httpRequest->setBody($body);
        return $this;
    }

    public function withParams($params) : IRequestBuilder
    {
        $this->httpRequest->setParams($params);
        return $this;
    }

    public function build() : IRequest
    {
        return $this->httpRequest;
    }
}