<?php

use Maer\Croute\Croute;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Maer\Croute\Croute
 */
class CrouteTest extends TestCase
{
    /**
    * @covers ::__construct()
    */
    public function testCrouteConstructor()
    {
        $routes = (new Croute([ROOT_CLASS]))->getRoutes();
        $this->assertEquals(2, count($routes), 'Invalid number of routes');

        $routes = (new Croute([CONTROLLERS_PATH]))->getRoutes();
        $this->assertEquals(4, count($routes), 'Invalid number of routes');
    }

    /**
    * @covers ::addPath()
    */
    public function testCrouteAddPath()
    {
        $croute = new Croute();
        $croute->addPath(ROOT_CLASS);
        $this->assertEquals(2, count($croute->getRoutes()), 'Invalid number of routes');

        $croute = new Croute();
        $croute->addPath([ROOT_CLASS, NAMESPACE_CLASS]);
        $this->assertEquals(4, count($croute->getRoutes()), 'Invalid number of routes');

        $croute = new Croute();
        $croute->addPath(CONTROLLERS_PATH);
        $this->assertEquals(4, count($croute->getRoutes()), 'Invalid number of routes');
    }
}
