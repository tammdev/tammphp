<?php

namespace Tamm\Framework\Skeleton\Web;

/**
 * Interface IRequestBuilder
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Web
 */

interface IRequestBuilder 
{
    public function withMethod($method) : IRequestBuilder;
    public function withHost($host) : IRequestBuilder;
    public function withPort($port) : IRequestBuilder;
    public function withUri($uri) : IRequestBuilder;
    public function withHeaders($headers) : IRequestBuilder;
    public function withBody($body) : IRequestBuilder;
    public function withParams($params) : IRequestBuilder;
    public function build() : IRequest;
}