<?php


namespace Core\Data;
use \ReflectionClass;
use \ReflectionException;

/**
 * Class SqlDatabaseCreator
 * @package Core\Data
 */
class SqlTableCreator
{
    private $db;

    function __construct(SqlDataBase &$dataBase) {
        $this->db = $dataBase;
    }

    /** Creates Database Table
     * @param String $name
     * @throws ReflectionException
     */
    public function create(String $name) {
        $this->db->execute($this->generateQuery($name));
    }

    /** generates the CREATE statement from the PHPDoc in Entity Class
     * @param $name - name of the entity in form folders\class
     * @return string - the SQL Query
     * @throws ReflectionException
     */
    private function generateQuery($name): string {
        $reflector = new ReflectionClass($name);
        $table = explode('*/', explode('@table ', $reflector->getDocComment())[1])[0];
        $fields = array_keys(get_object_vars(new $name()));
        $types = array();
        foreach($fields as $field) {
            $types[$field] = explode('*/', explode('@var ', $reflector->getProperty($field)->getDocComment())[1])[0];
        }

        $query = "CREATE TABLE " . $table . "(";
        foreach($types as $name => $type) {
            $query .= $name.' '.$type.',';
        }
        return substr($query, 0, -1) . ')';
    }
}