<?php

namespace tamm\framework\Annotations\Attributes;

#[Attribute(Attribute::TARGET_METHOD)]
class Post
{
    public function __construct(string $route)
    {
        $this->route = $route;
    }
}