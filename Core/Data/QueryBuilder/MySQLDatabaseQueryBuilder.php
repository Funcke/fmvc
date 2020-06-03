<?php

namespace Core\Data\QueryBuilder;

/**
 * Builder for generating SQL Queries.
 * 
 * This class provides a builder for creating SQL Queries in the 
 * MySQL Dialect.
 * This should help prevent typos and other types of common mistakes
 * happening in the manual creation of this type of query.
 * 
 * The following operations are being supported:
 * - Insert
 * - Select
 * - Update
 * - Delete
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * @package Core\Data\QueryBuilder
 * 
 * May 2020
 */
class MySQLDatabaseQueryBuilder implements SQLDatabaseQueryBuilder
{
    /**
     * Builder resource variable.
     * 
     * This variable is being used to generate the target query string.
     * Every time a method of the builder is being called,
     * the corresponding part will be appended to the variable.
     * When calling build(), the content of this variable will
     * be returned.
     * 
     * @var string
     */
    private $query;

    /**
     * Indicator variable for the beginning of a condition block.
     * Typical types of condition blocks are 'WHERE'-blocks. Here 
     * a start expression (e.g. 'WHERE' at the beginning of a where statemen)
     * is being required to properly for the statement.
     * 
     * A condition-generation method (e.g. where()) will start the 
     * condition block and set the variable to a value other than 0.
     * When the generation of the condition expression has finished,
     * the value will be set back to 0.
     * 
     * @var string
     */
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
     * Initiates a 'CREATE TABLE' statement, used to create new SQL-Tables.
     * 
     * This method initialized the internal query string with a
     * create-table statement. 
     * Please not, that this will also clear all previously present data in
     * the string.
     * 
     * @param string $table - name of the table to be crated
     * @param array $fields - associative array, with the format 
     *                        fieldname => Metadata-String
     *                        e.g. "username" => "varchar(255) NOT NULL"
     * 
     * @return SQLDatabaseQueryBuilder - the current SQLDatabaseQueryBuilder instance
     */
    public function create(string $table, array $fields): SQLDatabaseQueryBuilder
    {
        $this->query = 'Create Table '.$table."(";
        
        foreach($fields as $field => $meta) 
        {
            $this->query .= $field.' '.$meta.',';
        }
        
        $this->query = substr($this->query, 0, -1) . ')';
        $this->query = str_replace(' AUTOINCREMENT', ' AUTO_INCREMENT', $this->query);
        return $this;
    }

    /**
     * Creates basic select statement without any conditions.
     * 
     * This method generates a SQL 'SELECT'-statement. This type
     * of statement can be used to retrieve data from
     * a MySQL-Database.
     * When calling, all previous data will be erased from the
     * target query and will be replaced by a 'SELECT...' query.
     * 
     * If there is a need for additional filtering of the target
     * dataset, ::where() needs to be called afterwards,
     * as this method <strong>does not initialize the query
     * with any filter methodology.</strong>
     * 
     * @param string $table - string containing the name of the table 
     *                        to operate on.
     * @param array $fields - containing the fields has to be 
     *                        an array containing field names.
     * 
     * @return SqlDatabaseQueryBuilder
     */
    public function select(string $table, array $fields): SQLDatabaseQueryBuilder
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
     * Fills query with default insert statement.
     * 
     * This method provided a insert statement in the MySQL dialect.
     * The resulting statement can be used to insert data in MySQL tables.
     * No additional modification of the string necessary.
     * 
     * Please note, that by calling this method, all previously present 
     * data, which has been added to the builder will be removed
     * and replaced with an 'INSERT INTO'-statement.
     * 
     * @param string $table - name of the table to operate on
     * @param array $values - array containing fields in format 'column' => value
     * 
     * @return SqlDatabaseQueryBuilder
     **/
    public function insert(string $table, array $values): SQLDatabaseQueryBuilder
    {
        $this->query = 'INSERT INTO '.$table.'(';
        $this->conditions = 0;
        
        foreach(array_keys($values) as $val)
        {
            if(!is_null($values[$val]))
            {
                $this->query .= $val.', '; 
            }
        }
            
        $this->query = substr($this->query, 0, -2);
        $this->query .= ')VALUES(';
        
        foreach(array_values($values) as $val)
        {
            if(!is_null($val))
                $this->query .= '"'.$val.'", ';
        }
            
        $this->query = substr($this->query, 0, -2);
        $this->query .= ')';
            
        return $this;
    }
        
    /**
     * Creates simple update statement without conditions.
     * 
     * This method will generate an update statement in the MySQL Dialect.
     * The resulting method will not have any filtering options.
     * When there's a requirement for filtering, call ::where().
     * 
     * Please not that, by callig this method, all previously provided data
     * in the builder will be removed and replaced by the update statement.
     * 
     * @param string $table string containing name of table to operate on
     * @param array $values associative array containg fields and data in form of 'column' => val
     * 
     * @return SqlDatabaseQueryBuilder
     */
    public function update(string $table, array $values): SQLDatabaseQueryBuilder
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
     * Creates simple delete statement without any conditions.
     * 
     * This method generates a basic DELETE-statement in MySQL
     * dialect.
     * The resulting statement does not have any filtering and
     * will thus not work. Call ::where() before returning the
     * query.
     * 
     * Please note that, by calling this method, all previously 
     * generated data will be removed from the builder
     * an replaced by the basic delete query.
     * 
     * @param string $table - target table name
     * 
     * @return SqlDatabaseQueryBuilder
     */
    public function delete(string $table): SqlDatabaseQueryBuilder
    {
        $this->query = 'DELETE FROM '.$table;
        $this->conditions = 0;
            
        return $this;
    }
        
    /**
     * Adds condition to the querystring.
     * 
     * This method appends a 'WHERE'-statement to the previously
     * generated query. It can be used to provide filters and
     * precision to a resulting query like
     * UPDATE, DELETE or SELECT.
     * 
     * Please note that the only filtering type is by equals.
     * e.g. WHERE var1 = "value"
     * 
     * @param string $key contains column name
     * @param string $operator contains operator
     * @param string $value contains value to be compared to
     * 
     * @return SqlDatabaseQueryBuilder
     **/
    public function where(string $key, string $value):SQLDatabaseQueryBuilder
    {
        if($this->conditions == 0)
        {
            $this->query .= ' WHERE ';
            $this->conditions = 1;
        } 
        else
        {
            $this->query .= ' AND ';
        }
            
        $this->query .= $key."='".$value."'";
            
        return $this;
    }
        
    /**
     * Returns finished querystring
     * 
     * @return string
     */
    public function build():string
    {
        return $this->query;
    }
}