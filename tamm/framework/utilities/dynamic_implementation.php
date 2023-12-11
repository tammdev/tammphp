<?php

namespace Tamm\Framework\Utilities;

// Create a class that will implement the interface dynamically
class DynamicImplementation {
    // This method will implement the interface methods dynamically
    public static function implementInterface(string $interfaceName) {
        // Create a reflection class for the interface
        $reflectionInterface = new \ReflectionClass($interfaceName);

        // Create a reflection class for the dynamic implementation class
        $reflectionClass = new \ReflectionClass(self::class);

        // Get the methods of the interface
        $interfaceMethods = $reflectionInterface->getMethods();

        // Iterate through the interface methods
        foreach ($interfaceMethods as $interfaceMethod) {
            $methodName = $interfaceMethod->getName();
            $methodParameters = $interfaceMethod->getParameters();

            // Create a dynamic method in the implementation class
            $methodBody = "/* Add your implementation code here */";
            $methodSignature = self::getMethodSignature($interfaceMethod);
            $dynamicMethod = "public function $methodSignature { $methodBody }";

            // Create a method using the eval function
            eval($dynamicMethod);
        }

        // Create an instance of the dynamic implementation class
        $dynamicImplementation = $reflectionClass->newInstance();

        // Check if the created instance implements the interface
        if ($reflectionInterface->isInstance($dynamicImplementation)) {
            return $dynamicImplementation;
        } else {
            throw new \Exception("Failed to implement the interface.");
        }
    }

    // Helper method to get the method signature
    private static function getMethodSignature(\ReflectionMethod $method): string {
        $methodName = $method->getName();
        $methodParameters = $method->getParameters();
        $parameterList = [];

        foreach ($methodParameters as $parameter) {
            $parameterName = $parameter->getName();
            $parameterList[] = "$$parameterName";
        }

        $parameters = implode(", ", $parameterList);
        return "$methodName($parameters)";
    }
}