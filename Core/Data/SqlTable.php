<?php
namespace Core\Data {
    class SqlTable {
        public function store() {
            $data = json_decode(json_encode($this));
            $connection = new SqlDataBase();
            $connection->excute($this->build_insert());
        }
        
        private function build_insert(array $data): string {
            $builder = new QueryBuilder();
            return $builder->insert()
            ->table(get_class($this))
            ->parantheses(array_keys($data))
            ->values()
            ->parantheses(array_values($data))
            ->build();
        }
    }
}
?>
