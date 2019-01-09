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
        function __construct()
        {
            parent::__construct(explode('\\', get_class($this))[1]);
        }
        
        public function store()
        {
            return $this->store_raw(get_object_vars($this));
        }
        
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
                $ret = new $class();
                foreach($res as $key => $val)
                {
                    $ret->$key = $val;
                }
                return $ret;
            } else {
                return null;
            }
        }
        
        public static function find($arr):array
        {
            $class = get_called_class();
            $res = parent::get_raw(
                explode('\\', $class)[1],
                array_keys(get_object_vars(new $class())),
                $arr);
                
            if(!is_null($res))
            {
                $results = [];
                foreach($res as $entity)
                {
                    $et = new $class();
                    foreach($entity as $field => $value)
                    {
                        $et->$field = $value;
                    }
                    array_push($results, $et);
                }
                
                return $results;
            } else {
                return null;
            }
        }
        
        public function update():int
        {
            return parent::update_raw(get_object_vars($this), array('id' => $this->Id));
        }
        
        public function delete():int
        {
            return parent::delete_raw(array('id' => $this->Id));
        }
    }
}

?>