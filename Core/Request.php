<?php
namespace Core 
{
    /**
     * Request as sent by the client.
     * Serves as DTO for dispatching process.
     */
    class Request 
    {
        // Base Uri
        public $uri;

        // Navigation Components
        public $action;
        public $params;
        public $method;
        public $headers;
        public $session;
        public $cookies;
    }
}
