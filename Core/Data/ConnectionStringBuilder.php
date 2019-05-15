<?php


namespace Core\Data {


    class ConnectionStringBuilder
    {
        private $connection;

        function __construct()
        {
            $this->connection = "";
        }

        public static function new(): ConnectionStringBuilder
        {
            return new ConnectionStringBuilder();
        }

        public function driver(string $driver): ConnectionStringBuilder
        {
            $this->connection .= ($driver == '' ? '' : $driver . ':');
            return $this;
        }

        public function host(string $host): ConnectionStringBuilder
        {
            $this->connection .= ($host == '' ? '' : 'host=' . $host);
            return $this;
        }

        public function port(string $port): ConnectionStringBuilder
        {
            $this->connection .= ($port == '' ? '' : ':' . $port);
            return $this;
        }

        public function db(string $db): ConnectionStringBuilder
        {
            $this->connection .= ($db == '' ? '' : ',' . $db);
            return $this;
        }

        public function build(): string
        {
            return $this->connection;
        }
    }
}