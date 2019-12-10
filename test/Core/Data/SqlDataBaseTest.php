<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Data\SqlDataBase;

final class SqlDataBaseTest extends TestCase {
    
    public function testCanConnectToDb(): void
    {
        $thrown = false;
        try {
            $db = new SqlDataBase("", array("protocol" => "sqlite", "host" => "test/db/".uniqid(), "username" => "", "password" => ""));
        } catch(Exception $e) {
            $thrown = true;
        }

        $this->assertEquals($thrown, false);
    }

    public function testThrowsExceptionForInvalidQuery(): void 
    {
        $db = new SqlDataBase("", array("protocol" => "sqlite", "host" => "test/db/".uniqid(), "username" => "", "password" => ""));
        $thrown = false;
        try {
            $db->query("penis");
        } catch(\PDOException $e) {
            $this->assertEquals($e->getMessage(), "Invalid SQL Query: penis");
            $thrown = true;
        }
        $this->assertEquals($thrown, true);
    }

    public function testReturnsArrayFromValidQuery(): void 
    {
        $db = new SqlDataBase("", array("protocol" => "sqlite", "host" => "test/db/".uniqid(), "username" => "", "password" => ""));
        $db->execute("CREATE TABLE test(input varchar(50))");
        $thrown = false;
        try {
            $res = $db->query("SELECT * FROM test");
        } catch(\PDOException $e) {
            $thrown = true;
        }
        $this->assertEquals($thrown, false);
        $this->assertEquals(is_array($res), true);
        $this->assertEquals(empty($res), true);
    }

    public function testReturnsZeroIfExecuteWasNotSuccessful() : void 
    {
        $db = new SqlDataBase("", array("protocol" => "sqlite", "host" => "test/db/".uniqid(), "username" => "", "password" => ""));
        $db->execute("CREATE TABLE test(input varchar(50))");
        $res = $db->execute("INSERT INTO test(input, id) VALUES('69', 23)");
        $this->assertEquals($res, false);
    }
}