<?php

namespace Tamm\Framework\Annotations;

interface IAnnotationsRouteProvider
{
    function getRoutes(string $className) : array;
}