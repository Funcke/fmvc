<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Data\ConnectionStringProducer;
use Models\User;

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