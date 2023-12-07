<?php

namespace Tamm\Framework\Skelton\Middleware;

use Tamm\Framework\Skelton\Web\IRequest;

/**
 * Interface IMiddleware
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skelton\Middleware
 */

interface IMiddleware {
    public function process(IRequest $request, IClosure $next);
}