<?php

namespace Tamm\Framework\Annotations\Attributes;

#[Attribute(Attribute::TARGET_METHOD)]
class Put
{
    public function __construct(string $route)
    {
        $this->route = $route;
    }
}