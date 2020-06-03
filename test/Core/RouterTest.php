<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Core\Router;
use Core\Request;
use Core\Testing\TestEnvironmentAdapter;
use Core\Testing\TestUtils;
use Core\Util\PageUtils;

final class RouterTest extends TestCase 
{
    private function generateDefaultRouter($route, $method, $routes): Router 
    {
        $adapter = new TestEnvironmentAdapter($route, $method, 'application/json');
        return new Router($adapter, $routes);
    }

    /**
     * 
     * Test Router#formatURI
     * 
     */
    public function testFormatsURIAsExpected() 
    {
        $router = $this->generateDefaultRouter('/example', 'GET', array());
        $this->assertEquals('example', TestUtils::callPrivateMethod($router, 'formatURI', array()));
    }

    public function testHandlesURIWithoutLeadingSlash() 
    {
        $router = $this->generateDefaultRouter('example', 'GET', array());
        $this->assertEquals('example', TestUtils::callPrivateMethod($router, 'formatURI', array()));
    }

    public function testHandlesURIWithTrailingSlash() 
    {
        $router = $this->generateDefaultRouter('example/', 'GET', array());
        $this->assertEquals('example', TestUtils::callPrivateMethod($router, 'formatURI', array()));
    }

    public function testHandlesURIWithSlashInMiddle() 
    {
        $router = $this->generateDefaultRouter('example/test', 'GET', array());
        $this->assertEquals('example/test', TestUtils::callPrivateMethod($router, 'formatURI', array()));
    }

    /**
     * 
     * Test Router#handleRequest
     * 
     */
    public function testReturns404ErrorPageForInvalidURI() 
    {
        $router = $this->generateDefaultRouter('/example', 'GET', array());
        $returnValue = $router->handleRequest(new Request());
        $this->assertEquals($returnValue, PageUtils::renderErrorPage(
            array(
                'code' => 404,
                'message' => 'Url not found!'
                )
            )
        );
    }

    public function testReturns400PageForInvalidRequestMethod()
    {
        $router = $this->generateDefaultRouter('/example', 'POST', array('example' => array(
            'GET' => array(
                'controller' => "ExampleController::action",
                'middleware' => [],
                'validation' => ''
            )
            )));
        $returnValue = $router->handleRequest(new Request());
        $this->assertEquals($returnValue, PageUtils::renderErrorPage(
            array(
                'code' => 400,
                'message' => 'Wrong request method'
            )
            ));
    }
}