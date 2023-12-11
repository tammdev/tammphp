<?php

namespace Tamm\Framework\Annotations;

use Tamm\Application;
use tamm\framework\annotations\Attributes\Get;
use tamm\framework\annotations\Attributes\Post;
use tamm\framework\annotations\Attributes\Put;
use tamm\framework\annotations\Attributes\Delete;
use tamm\framework\annotations\Attributes\RestController;
use Tamm\Framework\Utilities\Reflection;

class RestControllerAnnotationHandler
{
    private const controllerName = 'RestController';

    public function handleAnnotations($className)
    {
        $reflectionClass = new \ReflectionClass($className);
        if ($reflectionClass->getAttributes(RestController::class))
        {
            $this->addRouteFromAttributesAnnotations($reflectionClass);
        }
        elseif ($this->hasAnnotation($reflectionClass, self::controllerName))
        {
            //Get annotations from docs though @RestController, @Get("/route")
            $this->addRouteFromDocsAnnotations($reflectionClass);
        }
    }

    private function addRouteFromAttributesAnnotations(\ReflectionClass $reflectionClass)
    {
        $attribute = null;
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

            $route = $attribute->getArguments()[0];
            $controllerName = $reflectionClass->getName();
            $actionName = $method->getName();
            $httpMethod = strtoupper(Reflection::getClassName($attribute->getName()));
            $args = $this->getParameterNames($method);

            Application::getOrienter()->addRoute($route, $controllerName, $httpMethod, $actionName, $args);
        }
    }

    private function addRouteFromDocsAnnotations(\ReflectionClass $reflectionClass)
    {
        $methods = $reflectionClass->getMethods();

        foreach ($methods as $method)
        {
            if (!$this->getRouteFromAnnotation($method))
            {
                continue;
            }

            $route = $this->getRouteFromAnnotation($method);
            $controllerName = $reflectionClass->getName();
            $actionName = $method->getName();
            $httpMethod = $this->getHttpMethodFromAnnotation($method);
            $args = $this->getParameterNames($method);

            Application::getOrienter()->addRoute($route, $controllerName, $httpMethod, $actionName, $args);
        }
    }

    private function getParameterNames(\ReflectionMethod $reflectionMethod)
    {
        $params = [];
        foreach($reflectionMethod->getParameters() as $parameter)
        {
            $parameterType = $parameter->getType();
            if ($parameterType !== null) {
                if ($parameterType instanceof \ReflectionNamedType) {
                    $params[] = $parameterType->getName();
                }
            }
        }

        return $params;
    }

    private function hasAnnotation($reflector, $annotationName) {
        $docComment = $reflector->getDocComment();

        return strpos($docComment, "@" . $annotationName) !== false;
    }

    private function getRouteFromAnnotation($method) {
        $docComment = $method->getDocComment();
        preg_match('/@([A-Za-z]+)\("([^"]+)"/', $docComment, $matches);

        return isset($matches[2]) ? $matches[2] : null;
    }

    private function getHttpMethodFromAnnotation($method) {
        $docComment = $method->getDocComment();
        preg_match('/@([A-Za-z]+)\("([^"]+)"/', $docComment, $matches);

        return isset($matches[1]) ? strtoupper($matches[1]) : null;
    }
}