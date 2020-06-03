<?php

namespace Core;

use Exception;

/**
 * Error representing a failing request.
 * When throwing this request in the request dispatching context,
 * the error handling will continue to render an error page
 * with the information about the error provided
 * in $message. It will also set the HTTP status code to the 
 * value provided in $code.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 */
class RequestError extends Exception
{
    /**
     * Represents the HTTP status code and also the HTTP
     * Error code that should be returned to the client.
     * 
     * @var int
     */
    public $code;
    /**
     * Error message to render into the error message body.
     * Should contain information for the consumer to understand
     * what type of error has happened when dispatching the 
     * request sent to the server.
     * 
     * @var string
     */
    public $message;
    
    /**
     * Constructor
     * @param int $code - http status code
     * @param string $message - Error message
     */
    public function __construct(int $code, string $message)
    {
        parent::__construct($message);
        $this->code = $code;
        $this->message = $message;
    }
}