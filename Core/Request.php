<?php
namespace Core;
    
/**
 * Request as sent by the client.
 * Serves as DTO for dispatching process.
 * 
 * This Class represents a wrapper around all resources
 * provided for an HTTP Request.
 * Not only does it serve for the router as data transfer
 * object which will be manipulated throughout the request
 * dispatching process, it also provides important metadata
 * about the request environment to the request handler method.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * @package Core
 */
class Request 
{
    /**
     * Application URI.
     * 
     * This property contains the part of the request_uri which is
     * relevant for the application context.
     * This means, that any sub folders the application is running
     * in will be splitted.
     * 
     * e.g. app runs in localhost:8080/my_app
     * When a request is sent to a route with the uri
     * localhost:8080/my_app/hello or localhost:8080/my_app/hello/,
     * only the part relevant for the navigation through the routes map
     * will be stored in this property
     * -> 'hello'.
     * 
     * @var string
     */
    public $uri;

    // Navigation Components
    /**
     * Name of the request handler method.
     * 
     * Contains the method that should be called to handle
     * the incoming request in the format:
     * ControllerName::Method
     * 
     * @var string
     */
    public $action;
    /**
     * All request parameters.
     * 
     * This variable contains a collection of 
     * data stored in all common places of an http request.
     * e.g. Query, Path and body.
     * 
     * @var array
     */
    public $params;
    /**
     * Http request method
     * 
     * @var string
     */
    public $method;
    /**
     * Request headers sent with the 
     * request.
     * 
     * @var string
     */
    public $headers;
    /**
     * Session associated with the session id
     * sent in the cookies of the request.
     * 
     * @var array
     */
    public $session;
    /**
     * Cookies
     * 
     * @var array
     */
    public $cookies;
    /**
     * Validation model to call on the 
     * content of $params property.
     * 
     * This property holds the name/path to the Dry::PHP
     * model, which should be used for validation in the context
     * of an incoming HTTP request.
     * 
     * @var string
     */
    public $validation;
    /**
     * Array of middleware methods.
     * 
     * This property holds an array with all the names of middleware
     * methods, that should be called before dispatching the 
     * initial request handler.
     * 
     * @var array
     */
    public $middleware = [];
}
