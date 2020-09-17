<?php
namespace FMVC;

use FMVC\Environment\EnvironmentAdapter;
use FMVC\Util\PageUtils;
use FMVC\Util\StringUtils;
use FMVC\RequestError;
use Dry\Exception\InvalidSchemaException;

/**
 * Request Lifecycle.
 * 
 * This class represents the whole lifecycle a request is running through.
 * Every request to an FMVC application will be handed to this class, which
 * will then start to apply all input validation checks, middleware calls 
 * and finally will call the desired controller action.
 * The result, which will be returned by #handleRequest() is the information,
 * which will be sent back to the calling client.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * @package FMVC
 */
class Router 
{
    /**
     * Routes available to this application.
     * 
     * This property holds the routes array passed to the router instance in
     * the consructor.
     * When a request is being dispatched, the router will handle accordingly
     * to the data declared in this variable.
     * For testing purposes please refer to the data declared in
     * './config/routes.php'
     * 
     * @var array
     */
    private $routes;
    /**
     * Environment adapter.
     * 
     * This variable represents the environment surrounding the request lifecycle.
     * As a request is not always being called in the context of
     * a running HTTP server, it is crucial to a functioning router to have the 
     * global dependencies it relies on injected through an abstraction layer.
     * 
     * The data provided in this class resembles properties, that would normally
     * be stored in:
     * - $_SERVER
     * - $_GET
     * - $_POST
     * - $_SESSION
     * - $_COOKIE
     * - getallheaders()
     * 
     * Especially when testing applications, this data will have to be abstracted.
     * In a normal production environment  (assuming an Apache Webserver), all data
     * necessary will be provided by an instance of 
     * FMVC\Environment\ProductionEnvironmentAdapter.
     * For testing usage, an instance of FMVC\Testing\TestEnvironmentAdapter is
     * recommended.
     * 
     * @var FMVC\Environment\EnvironmentAdapter
     */
    private $environment;

    /**
     * Constructor
     * 
     * @param FMVC\Environment\EnvironmentAdapter $environment - adapter providing all
     *                                                           necessary data from
     *                                                           the execution env.
     * @param array $routes - array with the structure of the routes available to
     *                        the router.
     */
    public function __construct(EnvironmentAdapter &$environment, array $routes) 
    {
        $this->routes = $routes;
        $this->environment = $environment;
    }

    /**
     * Exectes the request-handling lifecycle.
     * 
     * This method is the initial entrypoint for the request execution.
     * All requests handled by this instance of Router will be led through
     * this method.
     * 
     * The result of this method is the out put which will be printed into the
     * response body.
     * 
     * @param  Request $request Incoming request
     * 
     * @return string - response body in string format
     */
    public function handleRequest(Request $request) 
    {
        $request->uri = $this->formatURI();
        try {
            if(!\array_key_exists($request->uri, $this->routes))
                throw new RequestError(404, 'Url not found!');
           
            $this->handlePreflightRequest($request); 
                
            if($this->environment->server()['REQUEST_METHOD'] !== 'OPTIONS') 
            {
                $this->prepareRequest($request);
                $result = $this->dispatchRequest($request->action, $request);
            }
        } catch(RequestError $e) {
            $result = PageUtils::renderErrorPage(array('code' => $e->code, 'message' => $e->message));
        }
        
        return $result;
    }

    /**
     * Calls registered Middleware and Controller Action
     * 
     * This method represents the initial point of action.
     * All previously executed code aims to provide metadata
     * about the request and to process the incoming request.
     * 
     * At first all middleware methods declared in config/routes.php
     * will be called.
     * Afterwards the request input is being validated against the 
     * defined Dry::PHP Schema if one exists.
     * Please note, that each of this previously mentioned steps
     * and the defined components are able to interrupt and 
     * prematurely end request processing.
     * 
     * Especailly when validating request inputs or headers, 
     * it is common practice that the request processing will be 
     * canceled if insufficient data is being provided.
     * 
     * Finally, if everything previously mentioned has been executed
     * successfully and without any exceptions, the defined controller
     * action will be called.
     * The result of this action will be returned to the main execution
     * process.
     * 
     * If the controller wishes to end the request dispatching with
     * an error code, the controller should throw an exception providing
     * the desired status code and message.
     * 
     * @param  String $action     Action used
     * @param  Request $request    Request Object to dispatch
     * 
     * @return String - the result of the request handling
     * 
     * @throws FMVC\RequestError - thrown if an HTTP Error is desired
     */
    private function dispatchRequest(string $action, Request &$request) 
    {
        foreach($request->middleware as $mw)
        {
            require_once('Middleware/' .explode('::',$mw)[0] . '.php');
            $mw($request);
        }

        $this->validate($request);
        require_once('Controller/'. explode('::', $request->action)[0].'.php');
        return $action($request);
    }

    /**
     * Formats the incoming request URI
     * 
     * This method terminates the Request URI sent to the server in this request.
     * To minimize errors when routing to the correct controller actions,
     * the request URI is being modified in the following ways:
     * - split base_url from the begining, if one is defined
     * - split leading '/'
     * - split tailing '/'
     * 
     * When all these actions have been performed, the resulting
     * string will be returned.
     * 
     * @return String - URI formatted for request handling
     */
    private function formatUri()
    {
        $uri = explode("?", $this->environment->server()["REQUEST_URI"])[0];
            
        if(array_key_exists("base_url", $this->routes) && !empty($this->routes['base_url']))
            $uri = explode($this->routes['base_url'], $uri)[0];
            
        if(StringUtils::startsWith($uri, '/'))
            $uri = \substr($uri, 1);
            
        if(StringUtils::endsWith($uri, '/'))
            $uri = \substr($uri, 0, -1);
        return $uri;
    }

    /**
     * prepares Request for exection.
     * 
     * Checks if request methods match and if route is converted.
     * If the request method matches one of the handler provided by
     * the request uri, it will proceed with preparing the request.
     * If the request uri does not provide a handler for the given
     * method, the dispatching process will be exited with a 400 error
     * 
     * @param Request $request - request object to operate on
     * 
     * @throws RequestError
     */
    private function prepareRequest(Request &$request) 
    {
        if(!array_key_exists(
            $this->environment->server()["REQUEST_METHOD"], 
            $this->routes[$request->uri]
            )
        ) 
            throw new RequestError(400, 'Wrong request method');
        $this->initializeRequest($request);
    }

    /**
     * Set CORS headers on response
     * 
     * Especially when performing write requests to a server,
     * there's always the problem of the CORS filter.
     * To help minimizing one of the most commin use cases,
     * this method will provide the reponse header with the allowed
     * methods for this URL and the allowed headers.
     * 
     * @param Request $request - request object to operate on
     */
    private function handlePreflightRequest(Request &$request):void
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: '.\join(', ',array_keys($this->routes[$request->uri])));
        header('Access-Control-Allow-Headers: x-requested-with, Content-Type, origin, authorization, accept,');
        header('Access-Control-Max-Age: 86400');
    }

    /**
     * Initializes Request Object with metadata.
     * 
     * This method aims to provide the request object with metadata,
     * that can further be used by handler functions and middleware to
     * operate on e.g. headers, the session or request params.
     * 
     * It further initializes the request object with metadata
     * used by the router to perform its routing on.
     * 
     * @param Request $request - request object to operate on
     */
    private function initializeRequest(Request &$request):void
    {
        $request->headers = $this->environment->headers();
        $request->session = $this->environment->session();
        $request->cookies = $this->environment->cookies();
        $request->action = $this->routeObject($request)['controller'];

        if(array_key_exists('validation', $this->routeObject($request)))
            $request->validation = $this->routeObject($request)['validation'];

        $request->method = $this->environment->server()["REQUEST_METHOD"];
        
        if(array_key_exists('middleware', $this->routeObject($request)))
            $request->middleware = $this->routeObject($request)['middleware'];

        $request->params = &$this->getRequestParams();
    }

    /**
     * extracts request parameters and returns them as an array
     * 
     * This method retrieves the request parameters from one of 
     * the different places PHP provides them in.
     * Depending on the Content-Type header and the request method,
     * the data will converted if necessary.
     * The result will be returned back to the caller.
     * 
     * @return array - The found request parameters
     */
    private function &getRequestParams(): array
    {
        $params = [];
        switch($this->environment->server()["REQUEST_METHOD"]) 
        {
            case 'GET': $params = array_replace([], $this->environment->get()); break;
            case 'POST': 
                if($this->environment->server()["CONTENT_TYPE"] == "multipart/form-data" 
                   || $this->environment->server()["CONTENT_TYPE"] == "application/x-www-form-urlencoded")
                {
                    $params = array_replace([], $this->environment->post()); 
                    break;
                }
            case 'PUT':
                if(\preg_match("/application\/json(;(.)\w+(=)(.)\w+(-)(.)\w*)?/", $this->environment->server()["CONTENT_TYPE"]))
                {
                    $params = json_decode(file_get_contents("php://input"), true);
                    break;
                }
            case 'DELETE': parse_str(file_get_contents('php://input'), $params); break;
        }
        return $params;
    }

    /**
     * Helper method for accessing the entry in config/routes.php 
     * for the given request route/method combination.
     * 
     * @return array - entry for given request_uri and method
     */
    private function routeObject($request) {
        return $this->routes[$request->uri][$this->environment->server()["REQUEST_METHOD"]];
    }

    /**
     * Calls validation logic on given request object.
     * 
     * FMVC Uses Dry::PHP for validating the incoming request parameters
     * right before calling the handler logic.
     * If such a validation handler has beenr registered for the corresponding
     * request method in config/routes.php, this method will
     * be called and tries to execute the validation method on
     * the request body.
     * 
     * If the validation does not succeed, the request will be aborted
     * with status code 403.
     * 
     * @param Request $request - request to operate on
     * 
     * @throws RequestError - Error if checked data is invalid.
     */
    private function validate(Request &$request)
    {
        try {
            if($request->validation !== null) {
                require_once('Validation/'.$request->validation.'.php');
                (new $request->validation())->validate($request->params);
            }
        } catch(InvalidSchemaException $e) {
            throw new RequestError(403, "Invalid Request. Message: ".$e->getMessage());
        }
    }
}
