<?php

namespace Tamm\Core\Skelton;

// abstract class Middleware {
//     abstract public function process(HttpRequest $request, Closure $next);
// }

/**
 * Interface IMiddleware
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Core\Skelton
 */

interface IMiddleware {
    public function process(HttpRequest $request, Closure $next);
}