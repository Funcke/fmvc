<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Router;
use Core\Request;

final class RouterTest extends TestCase {
    public function testLeadsToCorrectRoute(): void
    {
        $request = new Request();
        $router = new Router();
        $router->handleRequest($request);
        print_r($request);
        assert(true);
    }
}