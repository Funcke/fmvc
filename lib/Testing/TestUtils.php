<?php
namespace FMVC\Testing;

/**
 * Utility class with methods useful for
 * testing.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * @package FMVC\Testing
 */
class TestUtils 
{
    /**
     * Makes a private method available for calling from outside
     * of the object.
     * This method aims to make fine grained testing easier.
     * 
     * @param Object $object - object to inoke the private method on
     * @param String $methodName - Name of the private method to invoke
     * @param Array $params - Params to pass to the private method
     * 
     * @return mixed - the result of the invoked method
     */
    public static function callPrivateMethod($object, $methodName, $params) 
    {
        $reflection = new \ReflectionClass(get_class($object));
        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);
        
        if(empty($params))
            return $method->invoke($object);
        else
            return $method->invokeArgs($object, $params);
    }
}