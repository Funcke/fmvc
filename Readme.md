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
Static assets such as CSS or JS are delivered normally and just have to be inlcuded in the header of base.php or another part of your view.

## Object Realtional Mapping
FMVC contains a small object realtional mapper. With it you can store, read, update and delete a class from your database.
The information about the connection needs to be stored in db.json. The connection should have the name 'default' as it is
the name the mapper will look for.
* How to strucutre the connectin information
```json
{
 "default": {
  "protocol": "mysql",
  "host": "localhost",
  "username": "root",
  "password": "root",
  "port": "3306",
  "databse": "my_db"
 }
}
```
Supported databases are: MySQL, SQLite, Microsoft SQL Server, PostgreSQL. The coresponding drivers need to be enabled in the php.ini seperately.
* Create an object the mapper can map
```php
use Core\Data\DataObject;
    /**
     * Class User
     * @package Models
     * @table User
     */
    class User extends DataObject
    {
        /**
         * @var int PRIMARY KEY AUTOINCREMENT
         */
        public $Id;
        /**
         * @var VARCHAR(50)
         */
        public $Username;
        /**
         * @var VARCHAR(50)
         */
        public $Email;
        /**
         * @var VARCHAR(100)
         */
        public $Password;
        /**
         * @var date
         */
        public $Birthdate;
        /**
         * @var int
         */
        public $EmailConfirmed;
        /**
         * @var date
         */
        public $CreatedAt;
        
        function __construct()
        {
            parent::__construct();
            $this->CreatedAt = date("Y-m-d H:i:s");
            $this->EmailConfirmed = 0;
        }
    }
```
The class needs to be in the Models namespace and resign in the Models directory. The PHPDoc comments create an interface needed by the mapper to create the table for the class if it not yet exists.
Because fo this, the comment above the class should contain a @table with the name of the table to store the object in.
The class member have a @var that specifies the type of the field in the table.
The class itself has to be a subclass of Core\data\DataObject. This class manages the creation of the table and provides the CRUD operaitons.
