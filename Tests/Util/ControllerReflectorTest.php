<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Tests\Util;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Shopping\ApiTKCommonBundle\Util\ControllerReflector;
use Symfony\Component\DependencyInjection\ContainerInterface;

class ControllerReflectorTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @var ContainerInterface|ObjectProphecy
     */
    private $containerInterface;

    /**
     * @var ControllerReflector
     */
    private $reflector;

    protected function setUp(): void
    {
        parent::setUp();

        $this->containerInterface = $this->prophesize(ContainerInterface::class);
        $this->reflector = new ControllerReflector($this->containerInterface->reveal());
    }

    public function testResolveSimpleDoublePoint(): void
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

        $this->assertIsArray($actual);
        $this->assertCount(2, $actual);

        list($class, $method) = $actual;

        $this->assertInstanceOf(\ReflectionClass::class, $class);
        $this->assertInstanceOf(\ReflectionMethod::class, $method);

        $this->assertEquals(ControllerExample::class, $class->getName());
        $this->assertEquals(ControllerExample::class, $method->getDeclaringClass()->getName());
        $this->assertEquals('someAction', $method->getName());
    }

    public function testResolveControllerOnly(): void
    {
        $this->containerInterface->has(MagicControllerExample::class)->shouldNotBeCalled();
        $this->containerInterface->get(MagicControllerExample::class)->shouldNotBeCalled();

        $actual = $this->reflector
            ->getReflectionClassAndMethod('Shopping\ApiTKCommonBundle\Tests\Util\MagicControllerExample');

        $this->assertIsArray($actual);
        $this->assertCount(2, $actual);

        list($class, $method) = $actual;

        $this->assertInstanceOf(\ReflectionClass::class, $class);
        $this->assertInstanceOf(\ReflectionMethod::class, $method);

        $this->assertEquals(MagicControllerExample::class, $class->getName());
        $this->assertEquals(MagicControllerExample::class, $method->getDeclaringClass()->getName());
        $this->assertEquals('__invoke', $method->getName());
    }

    public function testResolveFQCN(): void
    {
        $this->containerInterface->has(ControllerExample::class)->shouldNotBeCalled();
        $this->containerInterface->get(ControllerExample::class)->shouldNotBeCalled();

        $actual = $this->reflector
            ->getReflectionClassAndMethod('Shopping\ApiTKCommonBundle\Tests\Util\ControllerExample::anotherAction');

        $this->assertIsArray($actual);
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
 */
class ControllerExample
{
    public function someAction(): void
    {
    }

    public function anotherAction(): void
    {
    }
}

/**
 * Stub MagicControllerExample.
 */
class MagicControllerExample
{
    public function __invoke(): void
    {
    }
}
