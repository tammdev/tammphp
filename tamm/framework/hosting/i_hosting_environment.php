<?php

namespace Tamm\Framework\Hosting;

interface IHostingEnvironment
{
    function getApplicationName() : string;

    function getName() : string;

    function isDevelopment() : bool;

    function isStaging() : bool;

    function isProduction() : bool;
}