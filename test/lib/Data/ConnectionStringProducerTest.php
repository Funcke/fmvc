<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FMVC\Data\ConnectionStringProducer;

final class ConnectionStringProducerTest extends TestCase {
    public function testProducesValidMySQLConnectionString(): void
    {
        $params = array(
        "protocol" => "mysql",
        "host" => "localhost",
        "username" => "root",
        "password" => "password",
        "port"=> "3306",
        "database" => "db1"
        );
        $cs = ConnectionStringProducer::produce($params);
        $this->assertEquals('mysql:host=localhost;dbname=db1',$cs);
    }
    public function testProduceValidMicrosoftSqlServerConnectionString() : void
    {
        $params = array(
            "protocol" => 'sqlsrv',
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'password',
            'port' => '1433',
            'database' => 'db1'
        );
        $cs = ConnectionStringProducer::produce($params);
        $this->assertEquals('sqlsrv:Server=localhost;Port=1433;Database=db1', $cs);
    }
    public function testProduceValidPostgreSQLConnectionString() : void
    {
        $params = array(
            "protocol" => 'pgsql',
            'host' => 'localhost',
            'username' => 'root',
            'password' => 'password',
            'port' => '5432',
            'database' => 'db1'
        );
        $cs = ConnectionStringProducer::produce($params);
        $this->assertEquals('pgsql:host=localhost;port=5432;dbname=db1;user=root;password=password', $cs);
    }

    public function testProduceValidSQLite3ConnectionString(): void
    {
        $params = array(
            'protocol' => 'sqlite',
            'host' => 'file.db'
        );
        $cs = ConnectionStringProducer::produce($params);
        $this->assertEquals('sqlite:file.db', $cs);
    }
}