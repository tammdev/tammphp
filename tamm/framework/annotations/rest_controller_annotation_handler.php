<?php

namespace Tamm\Framework\Annotations;


use ReflectionClass;
use Tamm\Application;
use Tamm\Framework\Annotations\Attributes\RestController;

class RestControllerAnnotationHandler
{
    private array $annotationsProviders = [];

    public function __construct()
    {
        $this->annotationsProviders = [
            new AttributesAnnotationsRouteProvider(),
            new DocsAnnotationsRouteProvider()
        ];
    }

    public function handleAnnotations($className) : void
    {
        $routes = [];
        $reflectionClass = new ReflectionClass($className);
        if (count($reflectionClass->getAttributes(RestController::class)) != 0)
        {
            $routes = $this->annotationsProviders[0]->getRoutes($className);
        }
        elseif (DocsAnnotationsRouteProvider::hasAnnotation($reflectionClass))
        {
            //Get annotations from docs though @RestController, @Get("/route")
            $routes = $this->annotationsProviders[1]->getRoutes($className);
        }

        foreach ($routes as $route)
        {
            Application::getOrienter()
                ->addRoute($route['route'], $route['controllerName'], $route['httpMethod'], $route['actionName'], $route['args']);
        }
    }
}