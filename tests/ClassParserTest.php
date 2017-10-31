<?php

use Maer\Croute\Parser;

/**
 * @coversDefaultClass Maer\Croute\ClassParser
 */
class ClassParserTest extends \PHPUnit_Framework_TestCase
{
    /**
    * @covers ::parse
    */
    public function testClassParser()
    {
        $parser = new ClassParser(__DIR__ . '/Controllers/RootController.php');

        $routes = $parser->getRoutes();

        dd($routes);
    }
}
