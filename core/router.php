<?php
/**
 * @author Jonas Funcke <jonas@funcke.work>
 */
class Router {
    // contains content of config/routes.json
    private $routes;

    public function __construct($path) {
        $this->routes = json_decode(file_get_contents($path), true);
    }

    /**
     * Loads manages request handling and handles occuring errors
     */
    public function handleRequest($request) {
        $this->prepareRequest($request);
    
        $this->dispatchRequest($request->controller, $request->action, $request);
    }

    /**
     * load class and execute given action method
     */
    private function dispatchRequest($controller, $action, $request) {
        try{
            if(!include("controller/".$request->controller.".php")) {
                throw new Exception("Controller Not found");
            }
        } catch(Exception $e) {
            renderErrorPage(array("code" => 500, "message" => "Error finding controlller ".$request->controller));
        }
        

        if(method_exists($request->controller, $request->action))
            $controller::$action($request);
        else 
            renderErrorPage(array("code" => 500, "message" => "Controller does not contain method ".$request->action));
        
    }

    /**
     * prepares Request for exection. 
     * Checks if request methods match and if route is converted
     */
    private function prepareRequest($request) {
        if(array_key_exists("base_url", $this->routes)) {
            $request->uri = explode($this->routes["base_url"], $request->uri)[1];
        }
        if(!array_key_exists($request->uri, $this->routes)) {
            renderErrorPage(array("code" => 404, "message" => "url not found!"));
        } else {
            if($this->routes[$request->uri]["method"] == $_SERVER["REQUEST_METHOD"]) {
                $request->controller = $this->routes[$request->uri]["controller"];
                $request->action = $this->routes[$request->uri]["action"];
                $request->method = $this->routes[$request->uri]["method"];
                $this->getRequestParams($request);
            } else {
                renderErrorPage(array("code" => 400, "message" => "Wrong request method, ".$routes[$request->uri]["method"]." expected"));
            }
        }
    }

    /**
     * extracts request parameters and adds them to the request object
     */
    private function getRequestParams($request) {
        if($request->method == "GET") {
            $request->params = array_replace([], $_GET);
        }
        if($request->method == "POST") {
            $request->params = array_replace([], $_POST);
        }
        if($request->method == "PUT" || $request->method == "DELETE") {
            parse_str(file_getcontents('php://input'), $request->params);
        }
    }
}

?>