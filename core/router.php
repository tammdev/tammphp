<?php

namespace Tamm\Core;

class Router
{
    protected $routes = [];
    protected $modules = [];
    protected $themes = [];
    protected $events = [];

    public function addRoute($route, $handler)
    {
        $this->routes[$route] = $handler;
    }

    public function registerModule($moduleName)
    {
        $module = $this->getModuleFromDatabase($moduleName);
        if ($module) {
            $this->modules[$moduleName] = $module['path'];

            // Trigger 'module.registered' event
            // TODO 
            $this->events[0]->trigger('module.registered', ['moduleName' => $moduleName]);
        }
    }


    public function registerTheme($themeName)
    {
        $theme = $this->getThemeFromDatabase($themeName);
        if ($theme) {
            $this->themes[$themeName] = $theme;
        }
    }

    public function handle($uri)
    {
        // ...
    }

    protected function getModuleFromDatabase($moduleName)
    {
        // Code to retrieve module information from the database
        // Return an associative array with 'path' key
    }

    protected function getThemeFromDatabase($themeName)
    {
        // Code to retrieve theme information from the database
        // Return an associative array with theme information
    }

    public function subscribeToEvent($event, $listener)
    {
        // TODO
        $this->events[0]->subscribe($event, $listener);
    }
}
