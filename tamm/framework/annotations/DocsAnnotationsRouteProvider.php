<?php

namespace Tamm\Framework\Annotations;

use ReflectionClass;
use ReflectionMethod;
use ReflectionNamedType;

class DocsAnnotationsRouteProvider implements IAnnotationsRouteProvider
{
    private const controllerName = 'RestController';

    public function getRoutes(string $className): array
    {
        $routes = [];
        $reflectionClass = new ReflectionClass($className);
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method)
        {
            if (!self::hasAnnotation($reflectionClass))
            {
                continue;
            }

            $routes[] = [
                'route' => self::getRoute($method),
                'httpMethod' => self::getHttpMethod($method),
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

    public static function hasAnnotation($reflector) : bool
    {
        $docComment = $reflector->getDocComment();

        return str_contains($docComment, "@" . self::controllerName);
    }

    private static function getRoute($method) : ?string
    {
        $docComment = $method->getDocComment();
        preg_match('/@([A-Za-z]+)\("([^"]+)"/', $docComment, $matches);

        return $matches[2] ?? null;
    }

    private static function getHttpMethod($method) : ?string
    {
        $docComment = $method->getDocComment();
        preg_match('/@([A-Za-z]+)\("([^"]+)"/', $docComment, $matches);

        return isset($matches[1]) ? strtoupper($matches[1]) : null;
    }
}