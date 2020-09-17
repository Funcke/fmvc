<?php

namespace FMVC\Data;

use ReflectionClass;

class PHPDocUtils
{
    public static function getClassAnnotation($name, $property)
    {
        $reflector = new ReflectionClass($name);
        $propertyLine = explode('*', explode('@'.$property.' ', $reflector->getDocComment())[1])[0];
        return rtrim($propertyLine);
    }

    public static function getPropertyAnnotation($name, $property, $annotation)
    {
        $reflector = new ReflectionClass($name);
        $annotationValue = explode('*', explode('@'.$annotation.' ', $reflector->getProperty($property)->getDocComment())[1])[0];
        return rtrim($annotationValue);
    }
}