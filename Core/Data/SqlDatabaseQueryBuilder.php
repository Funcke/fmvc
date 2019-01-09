<?php

namespace Core\Data
{
    /**
     * Builder providing an easy to use api for creating CRUD SQL commands
     * 
     * @author Jonas Funcke <jonas@funcke.work>
     */
    class SqlDatabaseQueryBuilder
    {
        private $query;
        private $conditions;
        
        /**
         * Default c'tor.
         */
        function __construct()
        {
            $this->query = '';
            $this->conditions = 0;
        }
        
        
        /**
         * Creates basic select statement without any conditions
         * 
         * @param string $table string containing the name of the table to operate on
         * @param array $fields containing the fields has to be an array containing field names
         * 
         * @returns SqlDatabaseQueryBuilder
         */
        public function select(string $table, array $fields): SqlDatabaseQueryBuilder
        {
            $this->query = 'SELECT ';
            $this->conditions = 0;
            foreach($fields as $val)
            {
                $this->query .= $val.', ';
            }
            
            $this->query = substr($this->query, 0, -2);
            $this->query .= ' FROM '.$table;
            
            return $this;
        }
        
        /**
         * Fills query with default insert statement
         * 
         * @param string $table name of the table to operate on
         * @param array $values array containing fields in format 'column' => value
         * 
         * @returns SqlDatabaseQueryBuilder
         **/
        public function insert(string $table, array $values): SqlDatabaseQueryBuilder
        {
            $this->query = 'INSERT INTO '.$table.'(';
            $this->conditions = 0;
            $count = 0;
            $id = 0;
            foreach(array_keys($values) as $val)
            {
                if($val != 'Id'){
                    $this->query .= $val.', '; 
                }
            }
            
            $this->query = substr($this->query, 0, -2);
            $this->query .= ')VALUES(';
            $skipped = false;
            foreach(array_values($values) as $val)
            {
                if($skipped)
                    $this->query .= '"'.$val.'", ';
                else
                    $skipped = true;
            }
            
            $this->query = substr($this->query, 0, -2);
            $this->query .= ')';
            
            return $this;
        }
        
        /**
         * Creates simple update statement without conditions
         * 
         * @param string $table string containing name of table to operate on
         * @param array $values associative array containg fields and data in form of 'column' => val
         * 
         * @returns SqlDatabaseQueryBuilder
         */
        public function update(string $table, array $values): SqlDatabaseQueryBuilder
        {
            $this->query = 'UPDATE '.$table.' ';
            $this->conditions = 0;
            $this->query .= 'SET ';
            foreach($values as $k => $v)
            {
                $this->query .= $k.' = "'.$v.'", ';
            }
            $this->query = substr($this->query, 0, -2);
            
            return $this;
        }
        
        /**
         * Creates simple delete statement without any conditions
         * 
         * @param string $table containing table name
         * 
         * @returns SqlDatabaseQueryBuilder
         */
        public function delete(string $table): SqlDatabaseQueryBuilder
        {
            $this->query = 'DELETE FROM '.$table;
            $this->conditions = 0;
            
            return $this;
        }
        
        /**
         * Adds condition to the querystring
         * 
         * @param string $key contains column name
         * @param string $operator contains operator
         * @param string $value contains value to be compared to
         * 
         * @returns SqlDatabaseQueryBuilder
        **/
        public function where(string $key, string $value):SqlDatabaseQueryBuilder
        {
            if($this->conditions == 0)
            {
                $this->query .= ' WHERE ';
                $this->conditions = 1;
            } else {
                $this->query .= ' AND ';
            }
            
            $this->query .= $key.'='.$value;
            
            return $this;
        }
        
        /**
         * Returns finished querystring
         * 
         * @returns string
         */
        public function build():string
        {
            return $this->query;
        }
    }
}