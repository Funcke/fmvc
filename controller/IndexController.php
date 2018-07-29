<?php
include("core/controller.php");

class IndexController extends Controller{
    public static function index($request) {
        echo $request->method;
        echo "Hello, PHP";
    }

    public static function about($request) {
        if(!array_key_exists("name", $request->params)){
            $request->params["name"] = "World";
        }
        self::render("about", array("title" => "About you", "name" => $request->params["name"]));
    }

    public static function user($request) {
        self::render("user", array("title" => "User"));
    }
}

?>