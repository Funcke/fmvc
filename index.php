<?php

    /**
     * Entry-point for application.
     * Please extend as you wish. 
     * Please notice that handling requests will only work when this routine is executed
     *  at some point and that it resembles the final response creation and sending.
     */
    spl_autoload_register(function($classname) {
        include './core/'.$classname.'php';
    });
    session_start();
    
    $request = new Request();
    $router = new Router("config/routes.json");

    $router->handleRequest($request);
?>
