<?php
namespace Core {
  /**
   * @author Jonas Funcke <jonas@funcke.work>
   */
  use Core\PageUtils;
  class Router {
      // contains content of config/routes.json
      private $routes;

    /**
     * Constructor
     */
      public function __construct() {
          $this->routes = require_once('config/routes.php');
      }

      /**
       * Prepares rquest for execution and dispatches it
       * to the correct Controller method.
       * @param  Request $request Incoming request
       */
      public function handleRequest($request) {
          $this->prepareRequest($request);

          $this->dispatchRequest($request->action, $request);
      }

      /**
       * Calls Controller Action and renders belonging
       * Template file
       * @param  String $action     Action used
       * @param  Request $request    Request Object to dispatch
       * @return none
       */
      private function dispatchRequest(string $action, Request $request) {
          $action($request);
      }

      /**
       * prepares Request for exection.
       * Checks if request methods match and if route is converted
       */
      private function prepareRequest($request) {
          $base_url = array_key_exists("base_url", $this->routes)? $this->routes['base_url'] : '/';
          $request->uri = explode($base_url, $request->uri)[1];

          if(!array_key_exists($request->uri, $this->routes)) {
              PageUtils::renderErrorPage(array("code" => 404, "message" => "url not found!"));
          } else {
              if(array_key_exists($_SERVER["REQUEST_METHOD"], $this->routes[$request->uri])) {
                  $request->action = $this->routes[$request->uri][$_SERVER["REQUEST_METHOD"]];
                  $this->getRequestParams($request);
              } else {
                  PageUtils::renderErrorPage(array("code" => 400, "message" => "Wrong request method."));
              }
          }
      }

      /**
       * extracts request parameters and adds them to the request object
       */
      private function getRequestParams($request) {
          switch($_SERVER["REQUEST_METHOD"]) {
              case 'GET': $request->params = array_replace([], $_GET); break;
              case 'POST': $request->params = array_replace([], $_POST); break;
              case 'PUT':
              case 'DELETE': parse_str(file_getcontents('php://input'), $request->params); break;
          }
      }
  }
}
?>
