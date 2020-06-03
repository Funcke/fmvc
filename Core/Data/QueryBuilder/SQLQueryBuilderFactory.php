<?php

namespace Core\Data\QueryBuilder;

class SQLQueryBuilderFactory 
{
    public static function generate(string $dialect) : SQLDatabaseQueryBuilder
    {
        $builder = null;
        switch($dialect) 
        {
            case 'mysql': $builder = new MySQLDatabaseQueryBuilder(); break;
            case 'sqlite': $builder = new SQLiteDatabaseQueryBuilder(); break;
            case 'pgsql': break;
            case 'mssql': break;
        }

        return $builder;
    }
}