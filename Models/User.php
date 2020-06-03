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
         * @var integer PRIMARY KEY AUTOINCREMENT
         */
        public $id;
        /**
         * @var VARCHAR(50)
         */
        public $Username;
        /**
         * @var VARCHAR(50)
         */
        public $Firstname;
        /**
         * @var VARCHAR(50)
         */
        public $Lastname;
        /**
         * @var VARCHAR(100)
         */
        public $Email;
        /**
         * @var VARCHAR(256)
         */
        public $Password;
        /**
         * @var VARCHAR(240)
         */
        public $Description;
        /**
         * @var date
         */
        public $Birthdate;
        /**
         * @var VARCHAR(255)
         */
        public $Image;
        /**
         * @var date
         */
        public $CreatedAt;
        
        function __construct()
        {
            parent::__construct();
            $this->CreatedAt = date("Y-m-d H:i:s");
        }
    }
}

?>
