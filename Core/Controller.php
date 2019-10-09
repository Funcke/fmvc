<?php
namespace Core 
{
    /**
     * Base class for every controller.
     * Contains basic methods for page rendering
     *
     * @author Jonas Funcke <jonas@funcke.work>
     */
    class Controller 
    {
        public static function render(string $name, Request $request, array $params) 
        {
            if(file_exists("views/".$name.".php"))
                require_once("views/base.php");
            else
                PageUtils::renderErrorPage(array("code"=> 500, "message" => "Could not find template ".$name));
            exit();
      }
  }
}