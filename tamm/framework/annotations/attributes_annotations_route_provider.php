<?php

namespace Tamm\Framework\Annotations;

use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;
use Tamm\Framework\Annotations\Attributes\Delete;
use Tamm\Framework\Annotations\Attributes\Get;
use Tamm\Framework\Annotations\Attributes\Post;
use Tamm\Framework\Annotations\Attributes\Put;
use Tamm\Framework\Utilities\Reflection;

class AttributesAnnotationsRouteProvider implements IAnnotationsRouteProvider
{
    public function getRoutes(string $className): array
    {
        $routes = [];
        $reflectionClass = new ReflectionClass($className);
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method)
        {
            if (Reflection::hasAttribute($method, Get::class))
            {
                $attribute = $method->getAttributes(Get::class)[0];
            }
            elseif (Reflection::hasAttribute($method, Post::class))
            {
                $attribute = $method->getAttributes(Post::class)[0];
            }
            elseif (Reflection::hasAttribute($method, Put::class))
            {
                $attribute = $method->getAttributes(Put::class)[0];
            }
            elseif (Reflection::hasAttribute($method, Delete::class))
            {
                $attribute = $method->getAttributes(Delete::class)[0];
            }
            else
            {
                continue;
            }

            $routes[] = [
                'route' => $attribute->getArguments()[0],
                'httpMethod' => strtoupper(Reflection::getClassName($attribute->getName())),
                'controllerName' =>   $reflectionClass->getName(),
                'actionName' => $method->getName(),
                'args' => self::getParameterNames($method)
            ];
        }

        return $routes;
    }

    private static function getParameterNames(ReflectionMethod $reflectionMethod) : array
    {
        $params = [];
        foreach($reflectionMethod->getParameters() as $parameter)
        {
            $parameterType = $parameter->getType();
            if ($parameterType instanceof ReflectionNamedType) {
                $params[] = $parameterType->getName();
            }
        }

        return $params;
    }
}