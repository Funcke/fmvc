<?php
namespace FMVC\Environment;

class ProductionEnvironmentAdapter implements EnvironmentAdapter
{
    public function server() : array 
    {
        return $_SERVER;
    }

    public function &get() : array
    {
        return $_GET;
    }
    public function &post() : array
    {
        return $_POST;
    }
    public function &session() : array
    {
        return $_SESSION;
    }
    public function &cookies() : array
    {
        return $_COOKIE;
    }

    public function headers() : array
    {
        return getallheaders();
    }
}