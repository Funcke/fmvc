<?php
/**
 * Namespace containing all necessary classes of the framework
 */
namespace Core\Data  
{
    use \PDO;
    /**
     * Class representing the Database Connection. The implemented driver has to be defined
     * in the db.json file. As a connection meaning, the PDO class is used.
     * @author Jonas Funcke <jonas@funcke.work>
     */
    class SqlDataBase 
    {
        /**
         * Connection to the Database
         * @var PDO
         */
        private $connection;

        public $dialect;

        /**
         * c'tor
         * @param string $connection name of the connection configuration to open
         * @throws \PDOException if connection to DB fails
         * @throws \Exception if connection could not be opened
         */
        function __construct(string $connection = 'default', array $params = array()) 
        {
            if(empty($params))
                $params = json_decode(file_get_contents('./config/db.json'), true)[$connection];
            $query = ConnectionStringProducer::produce($params);
            $this->connection = new PDO($query, $params['username'], $params['password'], array(PDO::ATTR_PERSISTENT => TRUE));
            $this->dialect = $params['protocol'];
            if($this->connection == false) 
            {
                throw new \Exception('An error occured while connection to the databse!');
            }
    }

    /**
     * Executes the given query(<b>SELECT</b>)
     * Made for queries returning Results
     * @param string $query the query-string
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
            throw new \PDOException("Invalid SQL Query: ".$query);
        }
    }

    /**
     * Executes given statement (<b>INSERT, UPDATE, DELETE</b>)
     * Made for queries returning a int or boolean
     * @param  string $command Query
     * @return int             success information
     * @throws PDOException
     */
    public function execute(string $command):int
    {
        $res = $this->connection->exec($command);
        return $res;
    }

  }
}
