<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use FMVC\Data\QueryBuilder\MySQLDatabaseQueryBuilder;

final class MySQLDatabaseQueryBuilderTest extends TestCase {
    public function testGenerateSelectString(): void
    {
        $table = 'example';
        $fields = array(
            'id',
            'username',
            'password'
        );
        $query = (new MySQLDatabaseQueryBuilder())->select($table, $fields)->build();
        $this->assertEquals($query, "SELECT id, username, password FROM example");
    }

    public function testGenerateInsertString(): void
    {
        $table = 'example';
        $fields = array(
            'username' => '5318008',
            'firstname' => null,
            'lastname' => "'asldkf'",
            'catchy_field' => "'; drop table example"
        );
        $query = (new MySQLDatabaseQueryBuilder())->insert($table, $fields)->build();
        $this->assertEquals($query, "INSERT INTO example(username, lastname, catchy_field)VALUES(\"5318008\", \"'asldkf'\", \"'; drop table example\")");
    }

    public function testGenerateUpdateString(): void
    {
        $table = 'example';
        $fields = array(
            'username' => '5318008',
            'firstname' => null,
            'lastname' => "'asldkf'",
            'catchy_field' => "'; drop table example"
        );
        $query = (new MySQLDatabaseQueryBuilder())->update($table, $fields)->build();
        $this->assertEquals($query, "UPDATE example SET username = \"5318008\", firstname = \"\", lastname = \"'asldkf'\", catchy_field = \"'; drop table example\"");
    }

    public function testGenerateDeleteString(): void
    {
        $table = 'example';
        $query = (new MySQLDatabaseQueryBuilder())->delete($table)->build();
        $this->assertEquals($query, 'DELETE FROM example');
    }

    public function testGenerateWhereString(): void
    {
        $builder = new MySQLDatabaseQueryBuilder();
        $query = ($builder)->where('username', 'test')->build();
        $this->assertEquals($query, " WHERE username='test'");
        $query = $builder->where('password', 'Litec123')->build();
        $this->assertEquals($query, " WHERE username='test' AND password='Litec123'");
    }
}