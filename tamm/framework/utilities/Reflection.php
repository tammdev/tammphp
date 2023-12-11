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

    public  static function hasAttribute(\ReflectionMethod $reflectionMethod, string $attributeName) : bool
    {
        return count($reflectionMethod->getAttributes($attributeName)) > 0;
    }
}