<?php
namespace Core\Testing;

use Core\Request;
use Core\Router;

/**
 * Testing Router to call the application server during unit tests.
 * 
 * This class provides a wrapper around the router class.
 * It should enable developers to test their cofnigured routes
 * in automated tests.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * 
 * @package Core\Testing
 */
class TestingRouter 
{
    /**
     * Router instance to operate on
     * 
     * @var Core\Router
     */
    private $client;
    /**
     * Content of config/routes.php
     * 
     * @var Array
     */
    private $routes;

    /**
     * default c'tor
     * 
     * Initializes routes property
     */
    public function __construct()
    {
        $this->routes = require_once('config/routes.php');
    }

    /**
     * Send an HTTP GET Request to a route.
     * 
     * @param String $route - route to send the request to
     * @param Array $body - the request parameters to send alongside the requests
     * @param Array $headers - the request headers to send alongside the request
     * 
     * @return mixed - the response body
     */
    public function get(string $route, array $body, array $headers = [])
    {
        $request = new Request();
        $this->client = new Router(
            new TestEnvironmentAdapter(
                $route, 'GET', '', $body, 
                NULL, NULL, NULL, $headers
            ), 
            $this->routes, 
            $this->middleware
        );
        return $this->client->handleRequest($request);
    }
}