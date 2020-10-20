<?php
declare(strict_types=1);

require_once("vendor/autoload.php");

use PHPUnit\Framework\TestCase;
use FMVC\Data\ConnectionStringProducer;
use FMVC\Data\DataObject;

require_once("test/fixtures/User.php");

final class DataObjectTest extends TestCase {
    
    public function testProducesValidMySQLConnectionString(): void
    {
        $_ENV['env'] = 'test';
        (new User())->store();
        $users = User::all();
        $u = new User();
        $u->store();
        $this->assertTrue(sizeof($users) < sizeof((array)User::all()));
    }
}