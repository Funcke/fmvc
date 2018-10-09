<?php
namespace Core {
  /**
   * Request as sent by the client.
   * Serves as DTO for dispatching process.
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
}
?>
