# fmvc
A small Model-View-Controller framework.
It aimes heavily on separating code parts to create small, interchangeable components

## How-To Create a route
1. Create a class extending _Core\Controller_ in the folder _Controller_
```PHP
use Core\Controller;
public class ExampleController extends Controller {

}
```
2. Add a static method recieving a reference to _$request_. $request resembles an instance of _Core\Request Object_.
in this method resigns the task of your request endpoint. The reference is neccessary to manipulate the Session and other
properties of the request object.
```PHP
use Core\Controller;
use Core\Request;

public class ExampleController extends Controller {
 public static function action(Request &$request) {
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
