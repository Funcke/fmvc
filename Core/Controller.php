<?php
namespace Core;

use Core\Util\PageUtils;

/**
 * Base class for every controller.
 * Contains basic methods for page rendering.
 *
 * @author Jonas Funcke <jonas@funcke.work>
 */
class Controller 
{
    /**
     * Generates HTML from the given php files and stores it in a string.
     * 
     * This method represents a mapper around output buffer.
     * When called, it will render the file specified by $name
     * and wrap it within base.php.
     * Afterwards it stores the data from the buffer in a string and returns it.
     * 
     * @param string $name - Name of the template to include.
     * @param Request $request - Request object. Makes request metadata available
     *                           to the view, that should be rendered.
     * @param array $params - array with params, provided for the view.
     * 
     * @return string - rendered html in string format.
     */
    public static function render(string $name, Request $request, array $params) 
    {
        $result = '';
        
        if(file_exists("views/".$name.".php")) 
        {
            \ob_start();
            include("views/base.php");
            $result = \ob_get_clean();
            \ob_end_clean();
        }
        else
            $result = PageUtils::renderErrorPage(array("code"=> 500, "message" => "Could not find template ".$name));
        
        return $result;
    }

    /**
     * Generates JSON string from object
     * 
     * @param any $output - object to serialize
     * 
     * @return string - serialized object
     */
    public static function renderJSON($output) 
    {
        return json_encode($output);
    }   
}