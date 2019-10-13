<?php
    /**
     * Entry-point for application.
     * Please extend as you wish.
     * Please notice that handling requests will only work when this routine is executed
     *  at some point and that it resembles the final response creation and sending.
     */

use Core\Environment\ProductionEnvironmentAdapter;

session_start();

    error_reporting(E_ALL);
    require_once(__DIR__.'/vendor/autoload.php');
    
    $request = new Core\Request();
    $router = new Core\Router(new ProductionEnvironmentAdapter(), require_once('config/routes.php'), require_once('config/middleware.php'));

    $router->handleRequest($request);
?>
