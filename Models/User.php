<?php
namespace Models
{
    use Core\Data\DataObject;

    /**
     * Class User
     * @package Models
     * @table User
     */
    class User extends DataObject
    {
        /**
         * @var int PRIMARY KEY AUTOINCREMENT
         */
        public $Id;
        /**
         * @var VARCHAR(50)
         */
        public $Username;
        /**
         * @var VARCHAR(50)
         */
        public $Email;
        /**
         * @var VARCHAR(100)
         */
        public $Password;
        /**
         * @var date
         */
        public $Birthdate;
        /**
         * @var int
         */
        public $EmailConfirmed;
        /**
         * @var date
         */
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