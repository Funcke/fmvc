<?php
namespace Models
{
    use Core\Data\DataObject;
    class User extends DataObject
    {
        public $Id;
        public $Username;
        public $Email;
        public $Password;
        public $Birthdate;
        public $EmailConfirmed;
        public $CreatedAt;
        
        function __construct()
        {
            parent::__construct();
            $this->CreatedAt = date("Y-m-d H:i:s");
            $this->EmailConfirmed = 0;
        }
    }
}

?>