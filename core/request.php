<?php

/**
 * @author Jonas Funcke <jonas@funcke.work>
 * 
 * Class resembling the request.
 * Contains all important components of the request
 */
class Request {
    // Base Uri
    public $uri;

    // Navigation Components
    public $controller;
    public $action;
    public $params;
    public $method;
    public $headers;
    public $session;
    
    // Request parameters
    public $body;

    public function __construct() {
        $this->uri = explode("?", $_SERVER["REQUEST_URI"])[0];

        $this->headers = getallheaders();
        $this->session = &$_SESSION;
    }
}
?>