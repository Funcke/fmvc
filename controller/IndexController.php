<?php
use Core\DataBase;
use Core\Controller;

class IndexController extends Controller{
    public static function index($request) {
      self::render("index", array("title" => "Welcome"));
    }

    public static function create($request) {
      echo "Hello World";
    }

    public static function iJson($request) {
      echo json_encode(array("hallo" => "welt"));
    }
}

?>
