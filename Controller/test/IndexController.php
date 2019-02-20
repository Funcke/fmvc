<?php
error_reporting(E_ALL);
use Core\Controller;
use Models\User;

class IndexController extends Controller
{
    public static function index($request) 
    {
      /*if(array_key_exists('user', $request->session))
      {
        include 'views/dashboard.php'; 
      } else {
        include 'views/auth.php';
      }*/
      
      /*$var = new User();
      $var->Username = "Jonas";
      $var->Password = "Test";
      $var->Email = "jonas.funckegmail.com";
      $var->Birthdate = date("Y-m-d H:i:s");
      $var->store();*/
      
      $var = User::findById(18);
      echo json_encode($var);
      $var->Username = "Test";
      $var->update();
      echo json_encode(User::findById(18));
    }
}

?>
