<?php

namespace Core\Data\QueryBuilder;

class SQLQueryBuilderFactory {
    public static function generate(string $dialect) : SQLDatabaseQueryBuilder
    {
        $builder;
        switch($dialect) {
            case 'mysql': $builder = new MySQLDatabaseQueryBuilder(); break;
            case 'sqlite': break;
            case 'pgsql': break;
            case 'mssql': break;
        }

        return $builder;
    }
}