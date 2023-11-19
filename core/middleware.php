<?php

namespace Tamm\Core;

// abstract class Middleware {
//     abstract public function process(HttpRequest $request, Closure $next);
// }

interface IMiddleware {
    public function process(HttpRequest $request, Closure $next);
}