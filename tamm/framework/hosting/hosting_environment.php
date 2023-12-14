<?php

namespace Tamm\Framework\Hosting;

class HostingEnvironment implements IHostingEnvironment
{
    private string $name;
    private string $applicationName;

    public function __construct(string $name, string $applicationName)
    {
        $this->name = $name;
        $this->applicationName = $applicationName;
    }

    public function getApplicationName() : string
    {
        return $this->applicationName;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function isDevelopment() : bool
    {
        return $this->name == EnvironmentName::$Development;
    }

    public function isStaging() : bool
    {
        return $this->name == EnvironmentName::$Staging;
    }

    public function isProduction() : bool
    {
        return $this->name == EnvironmentName::$Production;
    }
}