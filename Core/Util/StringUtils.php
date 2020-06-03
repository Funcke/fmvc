<?php

namespace Core\Util;

/**
 * String utility class.
 * 
 * This class provides a collection of methods for manipulating and
 * querying strings in PHP.
 * Most of the provided methods are just wrappers around existing routines,
 * suited for common problems.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * @package Core\Util
 */
class StringUtils
{
    /**
     * Checks if a string starts with the given pattern.
     * 
     * @param String $haystack - target string
     * @param String $needle - pattern to query for
     * 
     * @return bool - true or false wether the string starts with the
     *                pattern or not.
     */
    public static function startsWith(string $haystack, string $needle): bool 
    {
        return (strpos($haystack, $needle) === 0);
    }

    /**
     * Checks if the given string ends with the a certain pattern.
     * 
     * @param String $haystack - target string
     * @param String $needle - target to search for
     * 
     * @return bool - true or false wether the string ends the the
     *                pattern or not.
     */
    public static function endsWith(string $haystack, string $needle): bool 
    {
        return substr_compare($haystack, $needle, -strlen($needle)) === 0;
    }
}