<?php


namespace Core\Data;

/**
 * Class ConnectionStringProducer
 * Produces Database connection string
 * @author Jonas Funcke <jonas@funcke.work>
 * @package Core\Data
 */
class ConnectionStringProducer
{
    /**
     * @param array $params - content from db.json
     * @return string - the connection string
     */
    public static function produce(array $params) : string
    {
        $query = '';
        switch($params['protocol'])
        {
            case 'sqlite': $query = self::produceSqlite($params); break;
            case 'mysql': $query = self::produceMySql($params); break;
            case 'pgsql': $query = self::producePGSQL($params); break;
            case 'sqlsrv': $query = self::produceSqlServer($params); break;
            default:

        }

        return $query;
    }

    private static function produceMySql(array $params): string
    {
        return "mysql:host=" . $params['host'] . ";dbname=" . $params['database'];
    }

    private static function produceSqlite(array $params): string 
    {
        return "sqlite:".$params['host'];
    }

    private static function produceSqlServer(array $params): string
    {
        return "sqlsrv:Server=" . $params['host'] . ";Port=" . $params['port'] . ";Database=" . $params['database'];
    }

    private static function producePGSQL(array $params): string
    {
        return 'pgsql:host=' . $params['host'] 
        . ';port='.$params['port'].';dbname=' . $params['database']
        .';user='.$params['username'].';password='.$params['password'];
    }
}