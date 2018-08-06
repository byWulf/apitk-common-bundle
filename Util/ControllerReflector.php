<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Util;

use Symfony\Component\DependencyInjection\ContainerInterface;

final class ControllerReflector
{
    private $container;

    private $controllers = [];

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Returns the ReflectionMethod for the given controller string.
     *
     * @param string $controller
     *
     * @return \ReflectionMethod|null
     */
    public function getReflectionMethod(string $controller)
    {
        $callable = $this->getClassAndMethod($controller);
        if (null === $callable) {
            return null;
        }

        list($class, $method) = $callable;

        try {
            return new \ReflectionMethod($class, $method);
        } catch (\ReflectionException $e) {
            // In case we can't reflect the controller, we just
            // ignore the route
        }
    }

    public function getReflectionClassAndMethod(string $controller)
    {
        $callable = $this->getClassAndMethod($controller);
        if (null === $callable) {
            return null;
        }

        list($class, $method) = $callable;

        try {
            return [new \ReflectionClass($class), new \ReflectionMethod($class, $method)];
        } catch (\ReflectionException $e) {
            // In case we can't reflect the controller, we just
            // ignore the route
        }
    }

    /**
     * @param string $controller
     *
     * @return array|null
     */
    private function getClassAndMethod(string $controller)
    {
        if (!isset($this->controllers[$controller])) {
            $this->controllers[$controller] = $this->detectClassAndMethod($controller);
        }

        return $this->controllers[$controller];
    }

    /**
     * @param string $controller
     *
     * @return array|null [$class, $method]
     */
    private function detectClassAndMethod(string $controller): ?array
    {
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
                $class = get_class($this->container->get($controller));

                if (!isset($method) && method_exists($class, '__invoke')) {
                    $method = '__invoke';
                }
            }
        }

        if (!isset($class) || !isset($method)) {
            return null;
        }

        return [$class, $method];
    }
}
