<?php
namespace FMVC\Util;
/**
 * Class PageUtils
 * Contains basic page utilities.
 *
 * @author Jonas Funcke <jonas@funcke.work>
 * @package FMVC\Util
 */
class PageUtils 
{
    /**
     * Render error page into base view and return rendered view
     * as a string.
     * Set error code as HTTP Response Code.
     * 
     * $params parameter is required to contain the following
     * fields:
     * - code: the http status code to set as response code
     * 
     * @param array $params - parameters accessible in page
     * 
     * @return String - rendered error view
     */
    public static function renderErrorPage($params) 
    {
        http_response_code($params["code"]);
        
        \ob_start();
        
        $name = "error";
        $params['title'] = $params['code'];
        include("views/base.php");
        $result = \ob_get_clean();
        
        \ob_end_flush();

        return $result;
    }
}