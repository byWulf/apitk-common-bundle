<?php

namespace Shopping\ApiTKCommonBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use Shopping\ApiTKCommonBundle\Util\ControllerReflector;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ControllerReflectorTest.
 *
 * @package Shopping\ApiTKCommonBundle\Tests
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
class ControllerReflectorTest extends TestCase
{
    /**
     * @var ContainerInterface
     */
    private $containerInterface;

    /**
     * @var ControllerReflector
     */
    private $reflector;

    protected function setUp()
    {
        parent::setUp();

        $this->containerInterface = $this->prophesize(ContainerInterface::class);
        $this->reflector = new ControllerReflector($this->containerInterface->reveal());
    }

    public function testResolveSimpleDoublePoint()
    {
        $controller = new ControllerExample();

        $this->containerInterface->has(ControllerExample::class)
            ->shouldBeCalled()
            ->willReturn(true);

        $this->containerInterface
            ->get(ControllerExample::class)
            ->shouldBeCalled()
            ->willReturn($controller);

        $actual = $this->reflector
            ->getReflectionClassAndMethod('Shopping\ApiTKCommonBundle\Tests\Util\ControllerExample:someAction');

        $this->assertInternalType('array', $actual);
        $this->assertCount(2, $actual);

        list($class, $method) = $actual;

        $this->assertInstanceOf(\ReflectionClass::class, $class);
        $this->assertInstanceOf(\ReflectionMethod::class, $method);

        $this->assertEquals(ControllerExample::class, $class->getName());
        $this->assertEquals(ControllerExample::class, $method->getDeclaringClass()->getName());
        $this->assertEquals('someAction', $method->getName());
    }

    public function testResolveControllerOnly()
    {
        $this->containerInterface->has(MagicControllerExample::class)->shouldNotBeCalled();
        $this->containerInterface->get(MagicControllerExample::class)->shouldNotBeCalled();

        $actual = $this->reflector
            ->getReflectionClassAndMethod('Shopping\ApiTKCommonBundle\Tests\Util\MagicControllerExample');

        $this->assertInternalType('array', $actual);
        $this->assertCount(2, $actual);

        list($class, $method) = $actual;

        $this->assertInstanceOf(\ReflectionClass::class, $class);
        $this->assertInstanceOf(\ReflectionMethod::class, $method);

        $this->assertEquals(MagicControllerExample::class, $class->getName());
        $this->assertEquals(MagicControllerExample::class, $method->getDeclaringClass()->getName());
        $this->assertEquals('__invoke', $method->getName());
    }

    public function testResolveFQCN()
    {
        $this->containerInterface->has(ControllerExample::class)->shouldNotBeCalled();
        $this->containerInterface->get(ControllerExample::class)->shouldNotBeCalled();

        $actual = $this->reflector
            ->getReflectionClassAndMethod('Shopping\ApiTKCommonBundle\Tests\Util\ControllerExample::anotherAction');

        $this->assertInternalType('array', $actual);
        $this->assertCount(2, $actual);

        list($class, $method) = $actual;

        $this->assertInstanceOf(\ReflectionClass::class, $class);
        $this->assertInstanceOf(\ReflectionMethod::class, $method);

        $this->assertEquals(ControllerExample::class, $class->getName());
        $this->assertEquals(ControllerExample::class, $method->getDeclaringClass()->getName());
        $this->assertEquals('anotherAction', $method->getName());
    }
}

/**
 * Stub ControllerExample.
 *
 * @package Shopping\ApiTKCommonBundle\Tests
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
class ControllerExample
{
    public function someAction()
    {
    }

    public function anotherAction()
    {
    }
}

/**
 * Stub MagicControllerExample.
 *
 * @package Shopping\ApiTKCommonBundle\Tests
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
class MagicControllerExample
{
    public function __invoke()
    {
    }
}
