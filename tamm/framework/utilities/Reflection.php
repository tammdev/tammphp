<?php

namespace Tamm\Framework\Utilities;

class Reflection
{
    private const separator = '\\';

    public static function getClassName($classFullName)
    {
        $tokens = explode(self::separator, $classFullName);

        return array_pop($tokens);
    }
}