<?php
namespace Core\Data {
    /**
     * 
     */
    class QueryBuilder {
        private $query;

        /**
         * Returns a new instace of the class
         */
        public static function new():QueryBuilder {
            return new QueryBuilder();
        }

        /**
         * c'tor
         */
        function __construct() {
            $this->query = "";
        }

        /**
         * Declares Query as a select statement
         * 
         * @return QueryBuilder Builder Object
         */
        public function select():QueryBuilder {
            $this->query = "SELECT ";
            return $this;
        }

        /**
         * Declares statement as update statement
         * 
         * @return QueryBuilder
         */
        public function update():QueryBuilder {
            $this->query = "UPDATE";
            return $this;
        }

        /**
         * Declares statement as delete statement
         * 
         * @return QueryBuilder
         */
        public function delete():QueryBuilder {
            $this->query = "DELETE FROM";
            return $this;
        }

        /**
         * Adds FROM to querystring
         * 
         * @return QueryBuilder
         */

        public function from():QueryBuilder {
            $this->query .= " FROM";
            return $this;
        }

        /**
         * Adds a field to the select statement
         * 
         * @param $field array the name of the column
         * @return QueryBuilder Builder Object
         */
        public function fields(array $fields):QueryBuilder {
            foreach($fields as $field) {
                $this->query .= " ".$field;
                $this->delimiter();
            }

            $this->query = substr($this->query, 0, -2);
            
            return $this;
        }

        /**
         * Adds a delimiter to querystring
         * 
         * @return QueryBuilder Builder Object
         */
        public function delimiter():QueryBuilder {
            $this->query .= ",";
            return $this;
        }

        /**
         * Adds tablename to querystring
         * 
         * @param string $table the tablename
         * @return QueryBuilder
         */
        public function table(string $table):QueryBuilder {
            $this->query .= " ".$table;
            return $this;
        }

        /**
         * Adds join to the querystring
         * 
         * @param string $table name of the joining table
         * @param string $type  type of join default is inner
         * @param string $on    condition of the join
         * 
         * @return QueryBuilder
         */
        public function join(string $table, string $type="inner", string $on):QueryBuilder {
            $this->query .= " ".$type." join ".$table." on ".$on;
            return $this;
        }

        /**
         * Adds WHERE to the querystring
         * 
         * @return QueryBuilder
         */
        public function where():QueryBuilder {
            $this->query .= " WHERE";
            return $this;
        }


        /**
         * Adds condition to querystring
         * 
         * @param string $field the field that is compared
         * @param string $comparator comparator used
         * @param string $conditon  condition value
         * 
         * @return QueryBuilder
         */
        public function condition(string $field, string $comparator, string $condition):QueryBuilder {
            $this->query .= " ".$field.$comparator.$condition;
            return $this;
        }

        /**
         * Declares statement as INSERT statement
         * 
         * @return QueryBuilder
         */
        public function insert():QueryBuilder {
            $this->query = "INSERT INTO";
            return $this;
        }

        /**
         * Adds field list in parantheses
         * 
         * @param array $fields array containing the names or the values to be used in the list
         * 
         * @return QueryBuilder
         */
        public function parantheses(array $fields):QueryBuilder {
            $this->query .= "(";
            $this->fields($fields);
            $this->query .= ")";
            return $this;
        }

        /**
         * Adds VALUES to querystring
         * 
         * @return QueryBuilder
         */
        public function values():QueryBuilder {
            $this->query .= " VALUES";
            return $this;
        }

        /**
         * Provides finished sql statement
         * 
         * @return string
         */
        public function build():string {
            return $this->query;
        }
    }
}
?>