<?php


namespace Core\Data;


class ConnectionStringProducer
{
    public static function produce($params) {
        $query = '';
        switch($params['protocol']) {
            case 'sqlite': $query = self::produceSqlite($params); break;
            case 'mysql': $query = self::produceMySql($params); break;
            case 'pgsql': $query = self::producePGSQL($params); break;
            case 'odbc': $query = self::produceSqlServer($params); break;
            default:

        }

        return $query;
    }

    private static function produceMySql(array $params): string {
        return "mysql:host=" . $params['host'] . ";dbname=" . $params['database'];
    }

    private static function produceSqlite(array $params): string {
        return "sqlite:".$params['host'];
    }

    private static function produceSqlServer(array $params): string {
        return "odbc:Driver={" . $params['driver'] . "};Server=" . $params['host'] . ";Port:" . $params['port'] . ";Database=" . $params['database'];
    }

    private static function producePGSQL(array $params): string {
        return 'pgsql:host=' . $params['host'] . ';dbname=' . $params['database'];
    }
}