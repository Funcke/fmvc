<?php

    /**
     * Entry-point for application.
     * Please extend as you wish.
     * Please notice that handling requests will only work when this routine is executed
     *  at some point and that it resembles the final response creation and sending.
     */
    use Core\Request;
    use Core\Router;

    session_start();

    spl_autoload_register(function (string $class) {
        $class = str_replace('\\', '/', $class);
        require_once($class . '.php');
    });

    $request = new Request();
    $router = new Router();

    $router->handleRequest($request);
?>
