<?php

namespace UnitTest\PhpDocReader;

use PhpDocReader\PhpDocReader;
use ReflectionParameter;

/**
 * @see https://github.com/mnapoli/PhpDocReader/issues/1
 */
class PrimitiveTypesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider jsonTypes
     */
    public function testPrimitives($type)
    {
        $parser = new PhpDocReader();

        $this->assertEquals($type, $parser->getPropertyClass('UnitTest\PhpDocReader\FixturesPrimitiveTypes\Class1', $type));
    }

    /**
     * @dataProvider ignoredTypes
     */
    public function testCompound($type)
    {
        $parser = new PhpDocReader();

        $this->assertNull($parser->getPropertyClass('UnitTest\PhpDocReader\FixturesPrimitiveTypes\Class1', $type));
    }


    /**
     * @dataProvider ignoredTypes
     */
    public function testMethodParameters($type)
    {
        $parser = new PhpDocReader();
        $parameter = new ReflectionParameter(['UnitTest\PhpDocReader\FixturesPrimitiveTypes\Class1', 'foo'], $type);

        $this->assertNull($parser->getParameterClass($parameter));
    }

    public function jsonTypes()
    {
        return [
            'bool'     => ['bool'],
            'boolean'  => ['boolean'],
            'string'   => ['string'],
            'int'      => ['int'],
            'integer'  => ['integer'],
            'float'    => ['float'],
            'double'   => ['double'],
            'array'    => ['array'],
            'object'   => ['object'],
        ];
    }

    public function ignoredTypes()
    {
        return [
            'callable' => ['callable'],
            'resource' => ['resource'],
            'mixed'    => ['mixed'],
        ];
    }
}
