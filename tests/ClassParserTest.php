<?php

use Maer\Croute\ClassParser;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Maer\Croute\ClassParser
 */
class ClassParserTest extends TestCase
{
    /**
    * @covers ::getRoutes()
    */
    public function testClassParserCount()
    {
        // Root class
        $routeCount = count($this->routes(ROOT_CLASS));
        $this->assertEquals(2, $routeCount, 'Invalid number of routes Root');

        // Namespace class
        $routeCount = count($this->routes(NAMESPACE_CLASS));
        $this->assertEquals(2, $routeCount, 'Invalid number of routes Namespace');
    }

    /**
    * @covers ::getRoutes()
    */
    public function testClassParserMethod()
    {
        // Root class
        $routes  = $this->routes(ROOT_CLASS);
        $this->assertEquals('GET', $routes[0]->method, 'Invalid root route method 1');
        $this->assertEquals('POST', $routes[1]->method, 'Invalid root route method 2');

        // Namespace class
        $routes  = $this->routes(NAMESPACE_CLASS);
        $this->assertEquals('GET', $routes[0]->method, 'Invalid ns route method 1');
        $this->assertEquals('POST', $routes[1]->method, 'Invalid ns route method 2');
    }

    /**
    * @covers ::getRoutes()
    */
    public function testClassParserRoute()
    {
        // Root class
        $routes  = $this->routes(ROOT_CLASS);
        $this->assertEquals('/', $routes[0]->route, 'Invalid root route value 1');
        $this->assertEquals('/root', $routes[1]->route, 'Invalid root route value 2');

        // Namespace class
        $routes  = $this->routes(NAMESPACE_CLASS);
        $this->assertEquals('/namespace/', $routes[0]->route, 'Invalid ns route value 1');
        $this->assertEquals('/namespace/root', $routes[1]->route, 'Invalid ns route value 2');
    }

    /**
    * @covers ::getRoutes()
    */
    public function testClassParserNames()
    {
        $routes  = $this->routes(NAMESPACE_CLASS);
        $this->assertEquals('namespace.index', $routes[0]->name, 'Invalid name value 1');
        $this->assertEquals('namespace.root', $routes[1]->name, 'Invalid name value 2');
    }

    /**
    * @covers ::getRoutes()
    */
    public function testClassParserFilters()
    {
        // Root
        $routes  = $this->routes(ROOT_CLASS);
        $before  = $routes[1]->before;
        $after   = $routes[1]->after;

        $this->assertEquals(2, count($before), 'Invalid count root route before');
        $this->assertEquals(1, count($after), 'Invalid count root route after');

        $this->assertEquals('rootBefore1', $before[0], 'Invalid root before 1');
        $this->assertEquals('rootBefore2', $before[1], 'Invalid root before 2');
        $this->assertEquals('rootAfter', $after[0], 'Invalid root after');

        // Namespace
        $routes  = $this->routes(NAMESPACE_CLASS);
        $before  = $routes[0]->before;
        $after   = $routes[1]->after;

        $this->assertEquals(2, count($before), 'Invalid count namespace route before');
        $this->assertEquals(2, count($after), 'Invalid count namespace route after');

        $this->assertEquals('classBefore', $before[0], 'Invalid namespace before 1');
        $this->assertEquals('getIndexBefore', $before[1], 'Invalid namespace before 2');
        $this->assertEquals('classfter', $after[0], 'Invalid namespace after 1');
        $this->assertEquals('postIndexAfter', $after[1], 'Invalid namespace after 2');
    }


    /**
     * Get a class route
     *
     * @param  string $file
     * @return array
     */
    protected function routes($file)
    {
        return (new ClassParser($file))->getRoutes();
    }
}
