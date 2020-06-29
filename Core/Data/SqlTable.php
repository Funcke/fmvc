<?php
namespace Core\Data;

use Core\Data\QueryBuilder\SQLQueryBuilderFactory;

/**
 * Base Class for Object Relational Mapping
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 */
abstract class SqlTable 
{
    private $connection;
    private $name;

    /**
     * default c'tor
     *
     * @param string $name
     * @param string $query
     * @throws \Exception
     */
    function __construct(string $name, $connection_name = '')
    {
        if(is_null($name))
            throw new \Exception('SqlTable has to have a name!!');
        if(empty($connection_name))
            $connection_name = (array_key_exists('env', $_ENV)? $_ENV['env']: 'default');
        $this->connection = new SqlDataBase($connection_name);
        $this->name = $name;
    }

    /**
     * calls build_insert and stores given data in table
     * representing current child-class
     * 
     * @param array $data associative array representing fields of child-Class to store in form of $field => $value
     * 
     * @return int 0 or 1 representing success of operation
     */
    protected function store_raw(array $data):int
    {
        $builder = SQLQueryBuilderFactory::generate($this->connection->dialect);
        $query = $builder->insert($this->name, $data)->build();
        return $this->connection->execute($query);
    }

    /**
     * Generates a SELECT statement and executes it on the table representing
     * the current childobject.
     *
     * @param string $name name of the Child-Class and the belonging table
     * @param array $fields containing the identifier of the fields to select
     * @param array $conditions containing the SELECT conditions in form of $field => $expectedVal
     *
     *
     * @return array with query results or false
     * @throws \Exception
     */
    protected static function get_raw(string $name, array $fields, array $conditions, string $connection_name):array
    {
        if(empty($connection_name))
            $connection_name = (array_key_exists('env', $_ENV)? $_ENV['env']: 'default');
        $connection = new SqlDataBase($connection_name);
        $builder= SQLQueryBuilderFactory::generate($connection->dialect);
        $builder->select($name, $fields);
        foreach($conditions as $field => $value)
        {
            $builder->where($field, $value);
        }
        $query = $builder->build();
        return $connection->query($query);
    }
        
    /**
     * Generates UPDATE statement from the given fields with the given contidions 
     * for the table representing the Child-Class and executes it.
     * 
     * @param array $fields associative array containing the identifier for
     *      the fields to update and their new values in form of $field => $value
     * 
     * @param array $conditions associative array containg identifier and expected
     *     value for conditioned fields in form of $field => $value
     * 
     * @return int 0 or higher, number of modified fields
     */
    protected function update_raw(array $fields, array $conditions = null):int
    {
        $builder = SQLQueryBuilderFactory::generate($this->connection->dialect);
        $builder->update($this->name, $fields);
        if(!is_null($fields))
        {
            foreach($conditions as $field => $value)
            {
                $builder->where($field, $value);
            }
        }
            
        $query = $builder->build();
        return $this->connection->execute($query);
    }
        
    /**
     * Generates DELETE statement for table representing Child-Class
     * deleteing all entries matching conditions provied by params
     * 
     * @param array $conditions array representing conditions in form of
     *     $field => $value
     * 
     * @return int 0 or more, number of deleted entries
     */
    protected function delete_raw(array $conditions = null):int
    {
        $builder = SQLQueryBuilderFactory::generate($this->connection->dialect);
        $builder->delete($this->name);
        $query = '';
        if($conditions != null)
        {
            foreach($conditions as $field => $value)
            {
                $builder->where($field, $value);
            }
            $query = $builder->build();
        } else {
            $query = $builder->build().' *';
        }
        
        return $this->connection->execute($query);
    }

    protected function &getConnection() {
        return $this->connection;
    }
}