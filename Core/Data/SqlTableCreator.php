<?php


namespace Core\Data;
use \ReflectionClass;
use \ReflectionException;

/**
 * Class SqlTableCreator
 * Creates Table from class
 *
 * @author Jonas Funcke <jonas@funcke.work>
 * @package Core\Data
 */
class SqlTableCreator
{

    /** Creates Database Table
     * @param String $name
     * @return string $query
     * @throws ReflectionException
     */
    public static function create(String $name) {
        return self::generateQuery($name);
    }

    /** generates the CREATE statement from the PHPDoc in Entity Class
     * @param $name - name of the entity in form folders\class
     * @return string - the SQL Query
     * @throws ReflectionException
     */
    private static function generateQuery($name): string {
        $reflector = new ReflectionClass($name);
        $table = explode('*', explode('@table ', $reflector->getDocComment())[1])[0];
        $fields = array_keys(get_class_vars($name));
        $types = array();
        foreach($fields as $field) {
            $types[$field] = explode('*', explode('@var ', $reflector->getProperty($field)->getDocComment())[1])[0];
        }
        $query = "CREATE TABLE " . $table . "(";
        foreach($types as $name => $type) {
            $query .= $name.' '.$type.',';
        }
        return substr($query, 0, -1) . ')';
    }
}
