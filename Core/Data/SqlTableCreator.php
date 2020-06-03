<?php


namespace Core\Data;

use Core\Data\QueryBuilder\SQLQueryBuilderFactory;
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
     * @param string $dialect
     * @return string $query
     * @throws ReflectionException
     */
    public static function createFromClass(String $name, string $dialect)
    {
        return self::generateQuery($name, $dialect);
    }

    /** generates the CREATE statement from the PHPDoc in Entity Class
     * @param $name - name of the entity in form folders\class
     * @return string - the SQL Query
     * @throws ReflectionException
     */
    private static function generateQuery(string $name, string $dialect): string
    {
        $table = PHPDocUtils::getClassAnnotation($name, 'table');
        $fields = array_keys(get_class_vars($name));
        $types = array();
        foreach($fields as $field) {
            $types[$field] = PHPDocUtils::getPropertyAnnotation($name, $field, 'var');
        }
        $query = (SQLQueryBuilderFactory::generate($dialect))->create($table, $types)->build();
        return $query;
    }
}
