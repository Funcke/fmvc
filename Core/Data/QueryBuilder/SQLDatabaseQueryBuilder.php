<?php

namespace Core\Data\QueryBuilder;

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
    public function create(string $table, array $fields): SQLDatabaseQueryBuilder;
    public function select(string $table, array $fields): SQLDatabaseQueryBuilder;
    public function insert(string $table, array $values): SQLDatabaseQueryBuilder;
    public function update(string $table, array $values): SQLDatabaseQueryBuilder;
    public function delete(string $table): SqlDatabaseQueryBuilder;
    public function where(string $key, string $value):SQLDatabaseQueryBuilder;
    public function build():string;
}