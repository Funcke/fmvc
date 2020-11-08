<?php

namespace FMVC\Environment;

class ApplicationContext
{
    protected static $instance;
    protected $controllerBasePath;
    protected $viewBasePath;
    protected $middlewareBasePath;
    protected $validationBasePath;

    protected function __construct($controllerBasePath, $viewBasePath, $middlewareBasePath, $validationBasePath)
    {
        $this->controllerBasePath = $controllerBasePath;
        $this->viewBasePath = $viewBasePath;
        $this->middlewareBasePath = $middlewareBasePath;
        $this->validationBasePath = $validationBasePath;
    }

    public static function forStandardFMVC()
    {
        self::$instance = new ApplicationContext("controller", "views", "middleware", "valdiation");
    }

    public static function getInstance()
    {
        return self::$instance;
    }

    public function requireController($name)
    {
        $this->requireResource($this->controllerBasePath, $name);
    }

    public function requireView($name)
    {
        $resourceIdentifier = $this->resourceString($this->viewBasePath, $name);
        if(file_exists($resourceIdentifier))
            return $resourceIdentifier;
        else
            throw new ResourceError(500, $resourceIdentifier." not found");
    }

    public function requireMiddleware($name)
    {
        $this->requireResource($this->middlewareBasePath, $name);
    }

    public function requireValidation($name)
    {
        $this->requireResource($this->validationBasePath, $name);
    }

    public function requireResource($base, $name)
    {
        $resourceIdentifier = $this->resourceString($base, $name);
        if(file_exists($resourceIdentifier))
            return require_once($resourceIdentifier);
        else
            throw new ResourceError(500, $resourceIdentifier." not found");
    }

    private function resourceString($base, $name)
    {
        return $base.'/'.$name.'.php';
    }
}