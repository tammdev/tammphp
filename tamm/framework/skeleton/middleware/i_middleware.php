<?php

namespace Tamm\Framework\Skeleton\Middleware;

use Tamm\Framework\Skeleton\Web\IRequest;

/**
 * Interface IMiddleware
 *
 * @author  Abdullah Sowailem <abdullah.sowailem@gmail.com>
 * @package Tamm\Framework\Skeleton\Middleware
 */

interface IMiddleware {
    public function process(IRequest $request, IClosure $next);
}