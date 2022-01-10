<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Describer;

use Doctrine\Common\Annotations\Reader;
use EXSyst\Component\Swagger\Operation;
use EXSyst\Component\Swagger\Path;
use EXSyst\Component\Swagger\Swagger;
use Generator;
use Nelmio\ApiDocBundle\Describer\DescriberInterface;
use ReflectionMethod;
use Shopping\ApiTKCommonBundle\Util\ControllerReflector;
use Symfony\Component\Routing\RouteCollection;

abstract class AbstractDescriber implements DescriberInterface
{
    public function __construct(
        protected RouteCollection $routeCollection,
        protected ControllerReflector $controllerReflector,
        protected Reader $reader
    ) {
    }

    public function describe(Swagger $api): void
    {
        $paths = $api->getPaths();
        foreach ($paths as $uri => $path) {
            foreach ($path->getMethods() as $method) {
                /** @var Operation $operation */
                $operation = $path->getOperation($method);

                foreach ($this->getMethodsToParse() as $classMethod => list($methodPath, $httpMethods)) {
                    if ($methodPath === $uri && in_array($method, $httpMethods)) {
                        $this->handleOperation($operation, $classMethod, $path, $method);
                    }
                }
            }
        }
    }

    abstract protected function handleOperation(
        Operation $operation,
        ReflectionMethod $classMethod,
        Path $path,
        string $method
    ): void;

    /**
     * @phpstan-ignore-next-line
     */
    protected function getMethodsToParse(): Generator
    {
        foreach ($this->routeCollection->all() as $route) {
            if (!$route->hasDefault('_controller')) {
                continue;
            }

            $controller = $route->getDefault('_controller');
            $callable = $this->controllerReflector->getReflectionClassAndMethod($controller);

            if ($callable) {
                $path = $this->normalizePath($route->getPath());
                $httpMethods = $route->getMethods() ?: Swagger::$METHODS;
                $httpMethods = array_map('strtolower', $httpMethods);
                $supportedHttpMethods = array_intersect($httpMethods, Swagger::$METHODS);

                if (empty($supportedHttpMethods)) {
                    continue;
                }

                yield $callable[1] => [$path, $supportedHttpMethods];
            }
        }
    }

    protected function normalizePath(string $path): string
    {
        if (str_ends_with($path, '.{_format}')) {
            $path = substr($path, 0, -10);
        }

        return $path;
    }
}
