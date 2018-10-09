<?php

    /**
     * Entry-point for application.
     * Please extend as you wish.
     * Please notice that handling requests will only work when this routine is executed
     *  at some point and that it resembles the final response creation and sending.
     */
    require_once('./core/Request.php');
    require_once('./core/Router.php');
    use Core\Request;
    use Core\Router;

    session_start();

    $request = new Request();
    $router = new Router("config/routes.json");

    $router->handleRequest($request);
?>
