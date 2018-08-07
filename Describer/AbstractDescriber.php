<?php

namespace Shopping\ApiTKCommonBundle\Describer;

use Doctrine\Common\Annotations\Reader;
use EXSyst\Component\Swagger\Operation;
use EXSyst\Component\Swagger\Swagger;
use Nelmio\ApiDocBundle\Describer\DescriberInterface;
use Shopping\ApiTKCommonBundle\Util\ControllerReflector;
use Symfony\Component\Routing\RouteCollection;

/**
 * Class AbstractDescriber.
 *
 * @package Shopping\ApiTKCommonBundle\Describer
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
abstract class AbstractDescriber implements DescriberInterface
{
    /**
     * @var RouteCollection
     */
    protected $routeCollection;

    /**
     * @var ControllerReflector
     */
    protected $controllerReflector;

    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @param RouteCollection     $routeCollection
     * @param ControllerReflector $controllerReflector
     * @param Reader              $reader
     */
    public function __construct(
        RouteCollection $routeCollection,
        ControllerReflector $controllerReflector,
        Reader $reader
    ) {
        $this->routeCollection = $routeCollection;
        $this->controllerReflector = $controllerReflector;
        $this->reader = $reader;
    }

    /**
     * @param Swagger $api
     */
    public function describe(Swagger $api)
    {
        $paths = $api->getPaths();
        foreach ($paths as $uri => $path) {
            foreach ($path->getMethods() as $method) {
                /** @var Operation $operation */
                $operation = $path->getOperation($method);

                foreach ($this->getMethodsToParse() as $classMethod => list($methodPath, $httpMethods)) {
                    if ($methodPath === $uri && in_array($method, $httpMethods)) {
                        $this->handleOperation($operation, $classMethod);
                    }
                }
            }
        }
    }

    /**
     * @param Operation         $operation
     * @param \ReflectionMethod $classMethod
     */
    abstract protected function handleOperation(Operation $operation, \ReflectionMethod $classMethod): void;

    /**
     * @return \Generator
     */
    protected function getMethodsToParse(): \Generator
    {
        foreach ($this->routeCollection->all() as $route) {
            if (!$route->hasDefault('_controller')) {
                continue;
            }

            $controller = $route->getDefault('_controller');
            if ($callable = $this->controllerReflector->getReflectionClassAndMethod($controller)) {
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

    /**
     * @param string $path
     *
     * @return string
     */
    protected function normalizePath(string $path): string
    {
        if ('.{_format}' === substr($path, -10)) {
            $path = substr($path, 0, -10);
        }

        return $path;
    }
}
