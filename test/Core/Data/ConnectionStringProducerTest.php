<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Data\ConnectionStringProducer;

final class ConnectionStringProducerTest extends TestCase {
    public function testProducesValidMySQLConnectionString(): void
    {
        $params = array(
            "protocol" => "mysql",
        "host" => "mysqlsvr70.world4you.com",
        "username" => "sql9722574",
        "password" => "i75fg@4",
        "port"=> "3306",
        "database" => "2265320db4"
        );
        $cs = ConnectionStringProducer::produce($params);
        $this->assertEquals('',
        $cs);
    }
}