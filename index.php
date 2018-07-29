<?php

    /**
     * Entry-point for application.
     * Please extend as you wish. 
     * Please notice that handling requests will only work when this routine is executed
     *  at some point and that it resembles the final response creation and sending.
     */
    session_start();
    include('core/router.php');
    include('core/request.php');
    include('core/pageUtils.php');
    
    $request = new Request();
    $router = new Router("config/routes.json");

    $router->handleRequest($request);
?>