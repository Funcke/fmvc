<?php
namespace Core\Environment;

interface EnvironmentAdapter
{
    public function server() : array;
    public function &get() : array;
    public function &post() : array;
    public function &session() : array;
    public function &cookies() : array;
    public function headers() : array;
}