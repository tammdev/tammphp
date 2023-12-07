<?php

namespace Tamm\Middleware;

use Tamm\Framework\HttpRequest;
use Tamm\Framework\IMiddleware;
use Tamm\Framework\Closure;
use Tamm\Framework\Log;

class LoggingMiddleware implements IMiddleware {
    public function process(HttpRequest $request, Closure $next) {
        // Perform logging or other operations before the request reaches the application
        Log::info('Request received: ' . $request->getUri());

        // Call the next middleware or the final application logic
        $response = $next($request);

        // Perform logging or other operations after the response is generated
        Log::info('Response sent: ' . $response->getStatusCode());

        return $response;
    }
}