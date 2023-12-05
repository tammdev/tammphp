<?php

namespace Tamm\Middleware;

use Tamm\Core\HttpRequest;
use Tamm\Core\IMiddleware;
use Tamm\Core\Closure;
use Tamm\Core\Log;

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