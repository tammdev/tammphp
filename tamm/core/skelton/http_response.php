<?php

namespace Tamm\Core\Skelton;

/**
 * Class HttpResponse
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */
class HttpResponse
{
    private $statusCode;
    private $headers;
    private $body;
    // private $messages = array();

    public function __construct($statusCode, $headers, $body)
    {
        $this->statusCode = $statusCode;
        $this->headers = $headers;
        $this->body = $body;
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }

    public function setHeader($name, $value)
    {
        return $this->headers[$name] = $value;
    }

    public function getHeaders()
    {
        return $this->headers;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function send()
    {
        // Set the status code
        http_response_code($this->statusCode);

        // Set the headers
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        // Send the response body
        echo $this->body;
    }
}