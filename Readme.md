# fmvc
A small Model-View-Controller framework.
It aimes heavily on separating code parts to create small, interchangeable components

## How-To Create a route
1. Create a class extending Core\Controller
```PHP
use Core\Controller;
public class ExampleController extends Controller {

}
```
2. Add a static method recieving a reference to $request. $request resembles the Core\Request Object.
in this method resigns the task of your request endpoint.
```PHP
use Core\Controller;
use Core\Request;

public class ExampleController extends Controller {
 public static function action(&$request) {
  echo "<h1>Hello World</h1>";
 }
}
```
## Create a view
1. create a php file with content to be displayed in _views_
2. edit base.php as you like. It resembles the basic page layout

## Assets
Stetic assets such as CSS or JS are delivered normally and just have to be inlcuded in the header of base.php

## Database
The DataBase-class provides automated connection to the database.
The corresponding informations have to be put into config/db.json
 -> currently supported are automatic INSERT and SELECT statements
## _Only compatible with apache webserver_
