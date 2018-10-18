<?php
/**
 * Namespace containing all necessary classes of the framework
 */
namespace Core\Data  {
  use \PDO;
  /**
   * Class representing the Database Connection
   */
  class SqlDataBase {
    /**
     * Connection to the Database
     * @var PDO
     */
    private $connection;

    /**
     * Default c'tor
     */
    function __construct() {
        $params = json_decode(file_get_contents('./config/db.json'), true);
        $this->connection = new PDO(
          $params['protocol'].'://'.$params['host'].':'.$params['port'].'/'.$params['database'],
          $params['username'],
          $params['password']);
        if($this->connection == false) {
          throw new Exception('An error occured while connection to the databse!');
        }
    }

    /**
     * Executes the given query(<b>SELECT</b>)
     * Made for queries returning Results
     * @param  string $query the query-string
     * @return array  result of query in associaitve array
     */
    public function query(string $query):array {
      $result = $this->connection->query($query);
      return $result->fetchAll();
    }

    /**
     * Executes given statement (<b>INSERT, UPDATE, DELETE</b>)
     * Made for queries returning a int or boolean
     * @param  [type] $command [description]
     * @return int             [description]
     */
    public function execute($command):int {
      return $this->connection->exec($command);
    }

    /**
     * Stores given object in Database
     * @param  object  $class Object to be stored
     * @return boolean        returns true wether the operation was successful
     */
    public function store(object $class):boolean {
      $object = json_decode(json_encode($class), true);
      $sql = "INSERT INTO ".get_class($class)."s(";
      foreach($object as $key => $value) {
        $sql .= $key.", ";
      }
      $sql = substr($sql, 0, -2);
      $sql .= ")";

      $this->connection->query($sql);
    }

    /**
     * Retrives one or more entries from the database matching
     * the given arguments.
     *
     * @param  string $fields    String listing fields to be selected from table
     * @param  string $table     Name of the class (and also the table)
     * @param  array  $arguments Array of arguments in form of "column" => "predicate"
     * @return array             Array of retrieved objects
     */
    public function retrieve(string $fields, string $table, array $arguments):array {
      $sql = "SELECT ".$fields." FROM ".$table;
      $sql = ($arguments == null? "" : " WHERE ");
      foreach($arguments as $key => $value) {
        $sql .= $key."= '".$value."'";
      }
      $results = [];
      foreach($this->connection->query($sql)->fetchAll() as $result) {
          array_push($results, (object)$result);
      }
      return $results;
    }
  }
}
?>
