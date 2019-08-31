<?php

namespace UnitTest\PhpDocReader;

use PhpDocReader\PhpDocReader;

/**
 * @see https://github.com/mnapoli/PHP-DI/issues/87
 */
class Issue87Test extends \PHPUnit_Framework_TestCase
{
    /**
     * This test ensures that use statements in class files take precedence in resolving type annotations
     * @see https://github.com/mnapoli/PHP-DI/issues/87
     */
    public function testGetParameterTypeUseStatementBeforeLocalNamespace()
    {
        $parser = new PhpDocReader();

        $target1 = new FixturesIssue87\TargetFixture1();

        $target1ReflectionClass = new \ReflectionClass($target1);
        $target1ReflectionMethod = $target1ReflectionClass->getMethod("SomeMethod");
        $target1ReflectionParams = $target1ReflectionMethod->getParameters();

        $result = $parser->getParameterClass($target1ReflectionParams[0]);

        //Since TargetFixture1 file has a use statement to the Subspace namespace, that's the one that should be returned
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture', $result);


        $result = $parser->getParameterClass($target1ReflectionParams[1]);

        //this parameter should be unaffected by use namespace since it has a relative type path
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);



        $target2 = new FixturesIssue87\TargetFixture2();

        $target2ReflectionClass = new \ReflectionClass($target2);
        $target2ReflectionMethod = $target2ReflectionClass->getMethod("SomeMethod");
        $target2ReflectionParams = $target2ReflectionMethod->getParameters();

        $result = $parser->getParameterClass($target2ReflectionParams[0]);

        //Since TargetFixture2 file has a use statement with an alias to the Subspace namespace, that's the one that should be returned
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);


        $result = $parser->getParameterClass($target2ReflectionParams[1]);

        //this parameter should be unaffected by use namespace since it has a relative type path
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);



        $target3 = new FixturesIssue87\TargetFixture3();

        $target3ReflectionClass = new \ReflectionClass($target3);
        $target3ReflectionMethod = $target3ReflectionClass->getMethod("SomeMethod");
        $target3ReflectionParams = $target3ReflectionMethod->getParameters();

        $result = $parser->getParameterClass($target3ReflectionParams[0]);

        //Since TargetFixture3 file has NO use statement, the one local to the target's namespace should be used
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\SomeDependencyFixture', $result);


        $result = $parser->getParameterClass($target3ReflectionParams[1]);

        //this parameter should be unaffected by use namespace since it has a relative type path
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);
    }


    /**
     * This test ensures that use statements in class files take precedence in resolving type annotations
     * @see https://github.com/mnapoli/PHP-DI/issues/87
     */
    public function testGetPropertyTypeUseStatementBeforeLocalNamespace()
    {
        $parser = new PhpDocReader();

        $target1 = new FixturesIssue87\TargetFixture1();

        $target1ReflectionClass = new \ReflectionClass($target1);
        $target1ReflectionProperty1 = $target1ReflectionClass->getProperty("dependency1");

        $result = $parser->getPropertyClass(get_class($target1), 'dependency1');

        //Since TargetFixture1 file has a use statement to the Subspace namespace, that's the one that should be returned
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture', $result);

        $result = $parser->getPropertyClass(get_class($target1), 'dependency2');

        //this property should be unaffected by use namespace since it has a relative type path
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);

        $target2 = new FixturesIssue87\TargetFixture2();

        $result = $parser->getPropertyClass(get_class($target2), 'dependency1');

        //Since TargetFixture2 file has a use statement with an alias to the Subspace namespace, that's the one that should be returned
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);

        $result = $parser->getPropertyClass(get_class($target2), 'dependency2');

        //this property should be unaffected by use namespace since it has a relative type path
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);

        $target3 = new FixturesIssue87\TargetFixture3();

        $result = $parser->getPropertyClass(get_class($target3), 'dependency1');

        //Since TargetFixture3 file has NO use statement, the one local to the target's namespace should be used
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\SomeDependencyFixture', $result);

        $result = $parser->getPropertyClass(get_class($target3), 'dependency2');

        //this property should be unaffected by use namespace since it has a relative type path
        $this->assertEquals('UnitTest\PhpDocReader\FixturesIssue87\Subspace\SomeDependencyFixture2', $result);
    }
}
