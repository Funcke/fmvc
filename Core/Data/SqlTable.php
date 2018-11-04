<?php
namespace Core\Data {
    /**
     * Base Class for Object Relational Mapping
     * 
     */
    class SqlTable {
        private $connection;
        private $data;
        /**
         * splits the object into an associative array
         * calls build_insert and stores it in Connection
         */
        public function store() {
            $this->prepare();
            $connection->excute($this->build_insert($data));
        }
        
        /**
         * Creates SQL Statement from given array fo data
         * 
         * @param array $data array containing the fields and values of an object
         * @return Finished query string, ready for DB insertion
         */
        private function build_insert(array $data): string {
            $builder = new QueryBuilder();
            return $builder->insert()
            ->table(get_class($this))
            ->parantheses(array_keys($data))
            ->values()
            ->parantheses(array_values($data))
            ->build();
        }
        
        /**
         * Selects all entries from database that fit conditions in
         * array given as parameter.
         * 
         * @param array $conditions array containing conditions in format array(array(field  => val, comparator => val, condition => val)
         * @return array of results
         */
        public static function find(array $contitions): array {
            $this->prepare();
            return $connection->query($this->build_find($data, $conditions));
        }
        
        private function build_find(array $fields, array $conditions): string {
            $builder = new QueryBuilder();
            $builder->select()
            ->fields(array_keys($fields), false)
            ->from()->table(get_class($this));
            foreach($conditions as $conditon) {
                $builder->condition($condition['field'], $condition['comparator'], $condition['condition']);   
            }
            
            return $builder->build();
        }
        
        public static function findById(number $id):array {
            $this->prepare();
            return $connection->query($this->build_find($data, array(array('field' => 'id', 'comparator' => '=', 'condition' => $id))));
        }
        
        private function prepare() {
            $data = json_decode(json_encode($this));
            $connection = new SqlDataBase();   
        }
    }
}
?>
