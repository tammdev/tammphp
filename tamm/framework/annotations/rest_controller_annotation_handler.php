<?php

namespace Tamm\Framework\Annotations;


// use ReflectionClass;
use Tamm\Application;

class RestControllerAnnotationHandler {

    public function handleAnnotations($className) {
        $reflector = new \ReflectionClass($className);
        $orienter = Application::getOrienter();
        // Check if the class has the @RestController annotation
        if ($this->hasAnnotation($reflector, 'RestController')) {
            $methods = $reflector->getMethods();

            foreach ($methods as $callback) {
                
                $route = $this->getRouteFromAnnotation($callback);

                // Skip methods without a route annotation
                if (!$route) {
                    continue;
                }

                $method = $this->getHttpMethodFromAnnotation($callback);

                //
                $args = array();
                // Get the callback parameters
                $parameters = $callback->getParameters();
                foreach($parameters as $parameter)
                {
                    $parameterType = $parameter->getType();
                    // Check if the parameter has a type declaration
                    if ($parameterType !== null) {
                        if ($parameterType instanceof \ReflectionNamedType) {
                            $args[] = $parameterType->getName();
                        }
                    }
                    // print_r($parameter->getType()->name);
                }

                // // Handle the route and http method
                // $this->handleRoute($route, $httpMethod);

                //
                $orienter->addRoute($route, $className, $method, $callback->getName(), $args);
            }
        }
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

    // private function handleRoute($route, $httpMethod) {
    //     // Handle the route and http method as needed
    //     echo "Route: $route, Method: $httpMethod\n";
    // }
}