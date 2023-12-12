<?php

namespace Tamm\Framework\Utilities;

// Create a class that will implement the interface dynamically
class DynamicImplementation {
    // This method will implement the interface methods dynamically
    public static function implement(string $targetName) {
        // Create a reflection class for the interface
        $reflectionTarget = new \ReflectionClass($targetName);

        $newClass = "TammNewClass";
        $classDeclaration = "";
        $classDeclaration .= "use $targetName; ";
        $targetNameArray = explode('\\',$targetName);
        $targetName = end($targetNameArray);

        $classDeclaration .= $reflectionTarget->isInterface()
            ? "class $newClass implements $targetName { "
            : "class $newClass extends $targetName { ";



        // Get the methods of the interface
        $interfaceMethods = $reflectionTarget->getMethods();

        // Iterate through the interface methods
        foreach ($interfaceMethods as $interfaceMethod) {
            // $methodName = $interfaceMethod->getName();
            $returnType = $interfaceMethod->getReturnType();
            // $methodParameters = $interfaceMethod->getParameters();

            // Create a dynamic method in the implementation class
            $methodBody = "/* Add your implementation code here */";
            $methodSignature = self::getMethodSignature($interfaceMethod);
            $dynamicMethod = "public function $methodSignature ";
            if ($returnType !== null) {
                $dynamicMethod .= " : $returnType";
            }
            $dynamicMethod .= "{ $methodBody } ";

            $classDeclaration .= $dynamicMethod;
            
        }
        $classDeclaration .= "}";
        // Create a method using the eval function
        eval($classDeclaration);

        // Create an instance of the dynamic implementation class
        $dynamicImplementation = new $newClass();

        // Check if the created instance implements the interface
        if ($reflectionTarget->isInstance($dynamicImplementation)) {
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
            $parameterName = $parameter->getType()." $$parameterName";
            if ($parameter->isDefaultValueAvailable()) {
                $defaultValue = $parameter->getDefaultValue();
                if (is_array($defaultValue)) {
                    $parameterName .= " = array()";
                }
            }

            $parameterList[] = $parameterName;
        }

        $parameters = implode(", ", $parameterList);
        return "$methodName($parameters)";
    }
}