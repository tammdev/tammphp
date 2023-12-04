<?php

namespace Tamm\Core\Annotations;


use ReflectionClass;

class RestControllerAnnotationHandler {
    public function handleAnnotations($className) {
        $reflector = new ReflectionClass($className);
        $routes = array();
        // Check if the class has the @RestController annotation
        if ($this->hasAnnotation($reflector, 'RestController')) {
            $methods = $reflector->getMethods();

            foreach ($methods as $method) {
                $route = $this->getRouteFromAnnotation($method);

                // Skip methods without a route annotation
                if (!$route) {
                    continue;
                }

                $httpMethod = $this->getHttpMethodFromAnnotation($method);

                // // Handle the route and http method
                // $this->handleRoute($route, $httpMethod);

                //
                $routes[$route] = array("method"=> $method, "callback" =>$httpMethod);
            }
        }
        return $routes;
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