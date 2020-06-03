<?php
namespace Core\Testing;

use Core\Environment\EnvironmentAdapter;

/**
 * 
 */
class TestEnvironmentAdapter implements EnvironmentAdapter
{
    private $server;
    private $get;
    private $post;
    private $session;
    private $cookies;
    private $headers;

    public function __construct(
        string $request_uri,
        string $request_method,
        string $content_type,
        array $get = NULL,
        array $post = NULL,
        array $session = NULL,
        array $cookies = NULL,
        array $headers = NULL
    ) 
    {
        $this->server = array('REQUEST_URI' => $request_uri, 'REQUEST_METHOD' => $request_method, 'CONTENT_TYPE' => $content_type);
        $this->get = $get;
        $this->post = $post;
        $this->session = $session;
        $this->cookies = $cookies;
        $this->headers = $headers;
    }
    
    public function server() : array 
    {
        return $this->server;
    }

    public function &get() : array
    {
        return $this->get;
    }
    public function &post() : array
    {
        return $this->post;
    }
    public function &session() : array
    {
        return $this->session;
    }
    public function &cookies() : array
    {
        return $this->cookies;
    }

    public function headers() : array
    {
        return $this->headers;
    }
}