<?php
namespace Core 
{

    use Core\Environment\EnvironmentAdapter;
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
        private $environment;

        /**
         * Constructor
         */
        public function __construct(EnvironmentAdapter &$environment, array $routes, array $middleware) 
        {
            $this->routes = $routes;
            $this->middleware = $middleware;
            $this->environment = $environment;
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
         * @return null
         */
        private function dispatchRequest(string $action, Request &$request) 
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
        private function prepareRequest(Request &$request) 
        {
            $request->uri = explode("?", $this->environment->server()["REQUEST_URI"])[0];
            $base_url = array_key_exists("base_url", $this->routes)? $this->routes['base_url'] : '/';
            $request->uri = explode($base_url, $request->uri)[1];

            if(!array_key_exists($request->uri, $this->routes)) 
            {
                PageUtils::renderErrorPage(array("code" => 404, "message" => "url not found!"));
            } 
            else 
            {
                if(array_key_exists($this->environment->server()["REQUEST_METHOD"], $this->routes[$request->uri])) 
                {
                    $this->initializeRequest($request);
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
        private function getRequestParams(Request &$request) 
        {
            switch($this->environment->server()["REQUEST_METHOD"]) 
            {
                case 'GET': $request->params = array_replace([], $this->environment->get()); break;
                case 'POST': 
                    if($this->environment->server()["CONTENT_TYPE"] == "multipart/form-data" || $this->environment->server()["CONTENT_TYPE"] == "application/x-www-form-urlencoded"){
                        $request->params = array_replace([], $this->environment->post()); 
                        break;
                    }
                case 'PUT':
                case 'DELETE': $request->params = json_decode(file_get_contents('php://input'), true); break;
            }
        }

        private function initializeRequest(Request &$request)
        {
            $request->headers = $this->environment->headers();
            $request->session = $this->environment->session();
            $request->cookies = $this->environment->cookies();
            $request->action = $this->routes[$request->uri][$this->environment->server()["REQUEST_METHOD"]];
            $request->method = $this->environment->server()["REQUEST_METHOD"];
            $this->getRequestParams($request);
        }
    }
}