<?php
require_once('./core/Controller.php');
require_once('./core/DataBase.php');
use \Core\DataBase;
use \Core\Controller;

class IndexController extends Controller{
    public static function index($request) {
      $connection = new DataBase();
      $_SESSION['Hello'] = 'Hello';
      echo $request->method;
      echo "Hello, PHP";
    }

    public static function about($request) {
        if(!array_key_exists("name", $request->params)){
            $request->params["name"] = "World";
        }
        self::render("about", array("title" => "About you", "name" => $request->params["name"]));
    }

    public static function json($request) {
      echo json_encode(array('test' => $_SESSION['Hello']));
    }

    public static function user($request) {
        self::render("user", array("title" => "User"));
    }
}

?>
