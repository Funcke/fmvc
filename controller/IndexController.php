<?php
use Core\Data\SqlDataBase;
use COre\Data\SqlStatementBuilder;
use Core\Controller;

class IndexController extends Controller{
    public static function index($request) {
      $data = new SqlDataBase();
      print_r($data->query("SELECT * FROM Test"));
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
