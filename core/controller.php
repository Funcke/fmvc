<?php

/**
 * Base class for every controller.
 * Contains all basic methods
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 */
class Controller {
    public static function render($name, $params) {
        if(file_exists("views/".$name.".php"))
            include("views/base.php");
        else
            renderErrorPage(array("code"=> 500, "message" => "Could not find template ".$name));
        exit();
    }
}

?>