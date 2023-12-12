<?php

namespace Tamm\Framework\Annotations\Attributes;

#[Attribute(Attribute::TARGET_METHOD)]
class Delete
{
    public function __construct(string $route)
    {
        $this->route = $route;
    }
}