<?php

namespace FMVC\Data\QueryBuilder;

/**
 * Interface containing common methods required by a builder for 
 * SQL Queries.
 * 
 * This interface is aimed at implementations that aim to provide
 * generation capabilities for SQL Queries, without any necessary
 * knowledge about SQL implementation specific syntax semantics.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 */
interface SQLDatabaseQueryBuilder 
{
    /**
     * Create an initial 'INSERT INTO' statement.
     * 
     * The array passed to this function should enable the user to specify the columns
     * and their respective values, that should be initialized in the resulting query.
     * The array should have the following format:
     * 'fieldname' => <value>
     * e.g.:
     * array(
     *  'username' => 'Richard'
     * );
     * 
     * @param string $table - name of the table to query in
     * @param array $fields - an associative array in the format fieldname => value,
     * 
     * @return SQLDatabaseQueryBuilder  - the current instance of the builder
     */
    public function create(string $table, array $fields): SQLDatabaseQueryBuilder;

    /**
     * Create an initial 'SELECT <properties> FROM <table>' statement.
     * 
     * This method initializes the query string with the basic parts of a
     * 'SELECT <properties> from <table>'. The <properties> are specified by the
     * array passed as the $fields parameter of the method.
     * The <table> is specified by the $table parameter of the method.
     * 
     * @param string $table - name of the table to query in.
     * @param array $fields - an ssociative array in the format fieldname => value
     * 
     * @return SQLDatabaseQueryBuilder  - the curret instance of the builder.
     */
    public function select(string $table, array $fields): SQLDatabaseQueryBuilder;

    /**
     * 
     */
    public function insert(string $table, array $values): SQLDatabaseQueryBuilder;
    public function update(string $table, array $values): SQLDatabaseQueryBuilder;
    public function delete(string $table): SqlDatabaseQueryBuilder;
    public function where(string $key, string $value):SQLDatabaseQueryBuilder;
    public function build():string;
}