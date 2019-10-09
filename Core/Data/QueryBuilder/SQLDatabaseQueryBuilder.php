<?php

namespace Core\Data\QueryBuilder {

    interface SQLDatabaseQueryBuilder {
        public function create(string $table, array $fields): SQLDatabaseQueryBuilder;
        public function select(string $table, array $fields): SQLDatabaseQueryBuilder;
        public function insert(string $table, array $values): SQLDatabaseQueryBuilder;
        public function update(string $table, array $values): SQLDatabaseQueryBuilder;
        public function delete(string $table): SqlDatabaseQueryBuilder;
        public function where(string $key, string $value):SQLDatabaseQueryBuilder;
        public function build():string;
    }
}