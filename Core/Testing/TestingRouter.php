<?php
namespace Core\Testing;

use Core\Router;
class TestingRouter {
    //Router instance
    private $client;
    private $routes;
    private $middleware;

    public function __construct() {
        $this->routes = require_once('config/routes.php');
        $this->middleware = require_once('config/middleware.php');
    }

    public function get(string $route, array $body, array $headers = array()):TestingRouter {
        $this->client = new Router(new TestEnvironmentAdapter($route, 'GET', '', $body, NULL, NULL, NULL, $headers), $this->routes, $this->middleware);
        $this->client->handle();
        return this;
    }
}