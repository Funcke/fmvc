<?php
namespace Core 
{
    use Core\PageUtils;

    /**
     * Dispatches incoming request and prepares Request DTO
     * @author jonas.funcke jonas@funcke.work
     */
    class Router 
    {
        // contains content of config/routes.json
        private $routes;
        private $middleware;

        /**
         * Constructor
         */
        public function __construct() 
        {
            $this->routes = require_once('config/routes.php');
            $this->middleware = require_once('config/middleware.php');
        }

        /**
         * Prepares rquest for execution and dispatches it
         * to the correct Controller method.
         * @param  Request $request Incoming request
         */
        public function handleRequest(Request $request) 
        {
            $this->prepareRequest($request);

            $this->dispatchRequest(end(explode('/',$request->action)), $request);
        }

        /**
         * Calls registered Middleware and Controller Action
         * @param  String $action     Action used
         * @param  Request $request    Request Object to dispatch
         * @return none
         */
        private function dispatchRequest(string $action, Request $request) 
        {
            foreach($this->middleware as $key => $val)
            {
                if($key == 'all' || $key == $request->uri)
                {
                    foreach($val as $mw)
                    {
                        require_once('Middleware/' .explode('::',$mw)[0] . '.php');
                        $mw($request);
                    }
                }
            }
            require_once('Controller/'. explode('::', $request->action)[0].'.php');
            $action($request);
        }

        /**
         * prepares Request for exection.
         * Checks if request methods match and if route is converted
         */
        private function prepareRequest(Request $request) 
        {
            $base_url = array_key_exists("base_url", $this->routes)? $this->routes['base_url'] : '/';
            $request->uri = explode($base_url, $request->uri)[1];

            if(!array_key_exists($request->uri, $this->routes)) 
            {
                PageUtils::renderErrorPage(array("code" => 404, "message" => "url not found!"));
            } 
            else 
            {
                if(array_key_exists($_SERVER["REQUEST_METHOD"], $this->routes[$request->uri])) 
                {
                    $request->action = $this->routes[$request->uri][$_SERVER["REQUEST_METHOD"]];
                    $this->getRequestParams($request);
                } 
                else 
                {
                    PageUtils::renderErrorPage(array("code" => 400, "message" => "Wrong request method."));
                }
            }
        }

        /**
         * extracts request parameters and adds them to the request object
         */
        private function getRequestParams(Request $request) 
        {
            switch($_SERVER["REQUEST_METHOD"]) 
            {
                case 'GET': $request->params = array_replace([], $_GET); break;
                case 'POST': 
                    if($_SERVER["CONTENT_TYPE"] == "multipart/form-data" || $_SERVER["CONTENT_TYPE"] == "application/x-www-form-urlencoded"){
                        $request->params = array_replace([], $_POST); 
                        break;
                    }
                case 'PUT':
                case 'DELETE': $request->params = json_decode(\file_get_contents('php://input'), true); break;
            }
        }
    }
}