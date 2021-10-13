<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Util;

use ReflectionClass;
use ReflectionException;
use ReflectionMethod;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ControllerReflector.
 *
 * @package Shopping\ApiTKCommonBundle\Util
 */
final class ControllerReflector
{
    private ContainerInterface $container;

    /**
     * @var array<string, array|null>
     */
    private $controllers = [];

    /**
     * ControllerReflector constructor.
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns the ReflectionMethod for the given controller string.
     */
    public function getReflectionMethod(string $controller): ?ReflectionMethod
    {
        $callable = $this->getClassAndMethod($controller);
        if (null === $callable) {
            return null;
        }

        list($class, $method) = $callable;

        try {
            return new ReflectionMethod($class, $method);
        } catch (ReflectionException $e) {
            // In case we can't reflect the controller, we just
            // ignore the route
        }

        return null;
    }

    /**
     * @param string $controller
     *
     * @return array<int, ReflectionClass|ReflectionMethod>|null
     */
    public function getReflectionClassAndMethod(string $controller): ?array
    {
        $callable = $this->getClassAndMethod($controller);
        if (null === $callable) {
            return null;
        }

        list($class, $method) = $callable;

        try {
            return [new ReflectionClass($class), new ReflectionMethod($class, $method)];
        } catch (ReflectionException $e) {
            // In case we can't reflect the controller, we just
            // ignore the route
        }

        return null;
    }

    /**
     * @param string $controller
     *
     * @return array<string, array|null>|null
     */
    private function getClassAndMethod(string $controller): ?array
    {
        if (!isset($this->controllers[$controller])) {
            $this->controllers[$controller] = $this->detectClassAndMethod($controller);
        }

        return $this->controllers[$controller];
    }

    /**
     * @return array<int, string>|null
     */
    private function detectClassAndMethod(string $controller): ?array
    {
        $matches = [];

        if (preg_match('#(.+)::([\w]+)#', $controller, $matches)) {
            $class = $matches[1];
            $method = $matches[2];
        } elseif (class_exists($controller)) {
            $class = $controller;
            $method = '__invoke';
        } else {
            if (preg_match('#(.+):([\w]+)#', $controller, $matches)) {
                $controller = $matches[1];
                $method = $matches[2];
            }

            if ($this->container->has($controller)) {
                $object = $this->container->get($controller);

                if ($object === null) {
                    return null;
                }

                $class = get_class($object);

                if (!isset($method) && method_exists($class, '__invoke')) {
                    $method = '__invoke';
                }
            }
        }

        if (!isset($class, $method)) {
            return null;
        }

        return [$class, $method];
    }
}
