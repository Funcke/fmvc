<?php

namespace Core\Data
{
    /**
     * Abstraction of SqlTable providing default
     * modificaiton methods for Objects.
     * 
     * @author Jonas Funcke <jonas@funcke.work>
     */
    class DataObject extends SqlTable
    {
        /**
         * DataObject constructor.
         * @throws \Exception
         */
        function __construct()
        {
            $fullName = get_class($this);
            parent::__construct(explode('\\', $fullName)[1]);
        }

        /**
         * Stores the data of the current object in the database
         * @return int - indicator of success or failure of the DB operation
         */
        public function store()
        {
            return $this->store_raw(get_object_vars($this));
        }

        /** Queries for DataObject with $id in table.
         * Returns object or else null.
         * @param int $id - id of the object to retrieve
         * @return DataObject|null - The found Object
         * @throws \Exception
         */
        public static function findById(int $id)
        {
            $class = get_called_class();
            
            $res = parent::get_raw(
                explode('\\', $class)[1],
                array_keys(get_object_vars(new $class())), 
                array('id' => $id));
            if(!is_null($res) && !empty($res))
            {
                $res = $res[0];
                return self::generate_object($class, $res);
            } else {
                return null;
            }
        }

        /** Finds all objects with properties the same as defined in $arr
         * Objects need to be passed as: $key = $value.
         * @param Array $arr
         * @return array
         * @throws \Exception
         */
        public static function find($arr)
        {
            $class = get_called_class();
            $res = parent::get_raw(
                explode('\\', $class)[1],
                array_keys(get_object_vars(new $class())),
                $arr);
            if(!is_null($res) && !empty($res))
            {
                $results = [];
                foreach($res as $entity)
                {
                    array_push($results, self::generate_object($class, $entity));
                }
                return $results;
            } else {
                return null;
            }
        }
        
        public static function all()
        {
            $class = get_called_class();
            $res = parent::get_raw(
                explode('\\', $class)[1],
                array_keys(get_object_vars(new $class())),
                array('1' => '1')
            );
            if(!is_null($res) && !empty($res))
            {
                $results = [];
                foreach($res as $entity)
                {
                    array_push($results, self::generate_object($class, $entity));
                }
                return $results;
            } else {
                return null;
            }
        }

        /** Stores current object in database taking the Id as identificator.
         * @return int - status of success
         */
        public function update():int
        {
            return parent::update_raw(get_object_vars($this), array('id' => $this->id));
        }

        /**
         * Deletes the current object from database.
         * @return int - status of success
         */
        public function delete():int
        {
            return parent::delete_raw(array('id' => $this->id));
        }

        private static function generate_object(string $class, array $properties)
        {
            $ret = new $class();
            foreach($properties as $key => $val)
            {
                $ret->$key = $val;
            }
            return $ret;
        }
    }
}