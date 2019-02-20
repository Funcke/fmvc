<?php
/**
 * Namespace containing all necessary classes of the framework
 */
namespace Core\Data  
{
    use \PDO;
    /**
     * Class representing the Database Connection
     * 
     * @author Jonas Funcke <jonas@funcke.work>
     */
    class SqlDataBase 
    {
        /**
         * Connection to the Database
         * @var PDO
         */
        private $connection;

        /**
         * c'tor
         * 
         * @param string $connection name of the connection configuration to open 
         */
        function __construct(string $connection = 'default') 
        {
            $params = json_decode(file_get_contents('./config/db.json'), true);
            $this->connection = new PDO(
                $params[$connection]['protocol'].':host='.$params[$connection]['host'].':'.$params[$connection]['port'].';dbname='.$params[$connection]['database'],
                $params[$connection]['username'],
                $params[$connection]['password']);
            if($this->connection == false) 
            {
                throw new Exception('An error occured while connection to the databse!');
            }
    }

    /**
     * Executes the given query(<b>SELECT</b>)
     * Made for queries returning Results
     * @param  string $query the query-string
     * @return array  result of query in associaitve array
     */
    public function query(string $query): array
    {
        $result = $this->connection->query($query);
        if($result != false)
        {
            $arr = [];
            while($row = $result->fetch(PDO::FETCH_ASSOC))
            {
                array_push($arr, $row);
            }
            
            return $arr;
        } else {
            return null;
        }
    }

    /**
     * Executes given statement (<b>INSERT, UPDATE, DELETE</b>)
     * Made for queries returning a int or boolean
     * @param  [type] $command [description]
     * @return int             [description]
     */
    public function execute($command):int 
    {
        $res = $this->connection->exec($command);
        if(!$res)
        {
            print_r ($this->connection->errorInfo());
        } 
        return $res;
    }
  }
}
?>
