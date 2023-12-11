<?php

namespace Tamm\Framework\Web;

use Tamm\Application;
use Tamm\Framework\Skeleton\Web\IRequest;

/**
 * Class HttpRequest
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Web
 */
class HttpRequest implements IRequest
{
    private static ?HttpRequest $instance = null;
    private string $host;
    private int $port;
    private string $method;
    private string $uri;
    private array $headers;
    private array $queryParams;
    private string $body;

    private function __construct()
    {
        //
        $this->host = $_SERVER['HTTP_HOST'] ?? null;
        //
        $this->port = $_SERVER['SERVER_PORT'] ?? null;
        //
        $this->method = $_SERVER['REQUEST_METHOD'] ?? null;
        //
        // Retrieve the URI
        $uri = "/".$_SERVER['REQUEST_URI'];
        $basePath = Application::getConfigurationValue("base_path");
        $fullUri = str_replace($basePath,"",$uri);
        $this->uri = explode('?',$fullUri)[0];
        //
        $headers = [];
        foreach ($_SERVER as $key => $value) {
            if (strpos($key, 'HTTP_') === 0) {
                $headerKey = str_replace('HTTP_', '', $key);
                $headerKey = str_replace('_', ' ', $headerKey);
                $headerKey = ucwords(strtolower($headerKey));
                $headerKey = str_replace(' ', '-', $headerKey);
                $headers[$headerKey] = $value;
            }
        }
        $this->headers = $headers;
        //
        $this->queryParams = $_GET;
        //
        $this->body = file_get_contents('php://input');
    }

    public static function getInstance(){
        if(self::$instance === null){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * Get request body data
     *
     * @return string|null
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Get request body data
     *
     * @return int|null
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Get the request method (GET, POST, etc.)
     *
     * @return string|null
     */
    public function getMethod() {
        return $this->method;
    }

    /**
     * Get the request URL
     *
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Get request headers
     *
     * @return array
     */
    public function getHeaders() {
        return $this->headers;
    }

    /**
     * Get request query parameters
     *
     * @return array
     */
    public function getQueryParams() {
        return $this->queryParams;
    }

    /**
     * Get request body data
     *
     * @return string|null
     */
    public function getBody() {
        return $this->body;
    }
}