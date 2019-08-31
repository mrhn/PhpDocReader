<?php

namespace UnitTest\PhpDocReader;

use PhpDocReader\PhpDocReader;
use ReflectionParameter;

/**
 * Test exceptions when a class doesn't exist.
 */
class NonExistentClassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException \PhpDocReader\AnnotationException
     * @expectedExceptionMessage The @var annotation on UnitTest\PhpDocReader\FixturesNonExistentClass\Class1::prop contains a non existent class "Foo". Did you maybe forget to add a "use" statement for this annotation?
     */
    public function testProperties()
    {
        $parser = new PhpDocReader();
        $parser->getPropertyClass('UnitTest\PhpDocReader\FixturesNonExistentClass\Class1', 'prop');
    }

    /**
     * @expectedException \PhpDocReader\AnnotationException
     * @expectedExceptionMessage The @param annotation for parameter "param" of UnitTest\PhpDocReader\FixturesNonExistentClass\Class1::foo contains a non existent class "Foo". Did you maybe forget to add a "use" statement for this annotation?
     */
    public function testMethodParameters()
    {
        $parser = new PhpDocReader();
        $parameter = new ReflectionParameter(array('UnitTest\PhpDocReader\FixturesNonExistentClass\Class1', 'foo'), 'param');

        $parser->getParameterClass($parameter);
    }
}
