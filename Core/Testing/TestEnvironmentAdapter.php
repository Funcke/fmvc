<?php
namespace Core\Testing;

use Core\Environment\EnvironmentAdapter;

/**
 * Adapter to provide access to common resources of
 * an PHP environment.
 * 
 * Serves as mocking adapter for testing purposes.
 * 
 * @author Jonas Funcke <jonas@funcke.work>
 * @package Core\Testing
 */
class TestEnvironmentAdapter implements EnvironmentAdapter
{
    /**
     * Can hold data which would normally be stored
     * in the $_SERVER variable.
     * 
     * @var array
     */
    private $server;
    /**
     * Holds data which would normally be populated into
     * $_GET superglobal.
     * 
     * @var array
     */
    private $get;
    /**
     * Holds data which would normally be populated into
     * $_POST superglobal.
     * 
     * @var array
     */
    private $post;
    /**
     * Holds data which would normally be populated into
     * $_SESSION superglobal.
     * 
     * @var array
     */
    private $session;
    /**
     * Holds data which would normally be populated into
     * $_COOKIE superglobal.
     * 
     * @var array
     */
    private $cookies;
    /**
     * Represents header provider.
     * 
     * @var array
     */
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