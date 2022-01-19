<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Describer;

use Nelmio\ApiDocBundle\OpenApiPhp\Util;
use OpenApi\Annotations as OA;
use Symfony\Component\Routing\Route;

trait RouteDescriberTrait
{
    /**
     * @return OA\Operation[]
     */
    private function getOperations(OA\OpenApi $api, Route $route): array
    {
        $operations = [];
        $path = Util::getPath($api, $this->normalizePath($route->getPath()));
        $methods = $route->getMethods() ?: Util::OPERATIONS;
        foreach ($methods as $method) {
            $method = strtolower($method);
            if (!in_array($method, Util::OPERATIONS)) {
                continue;
            }

            $operations[] = Util::getOperation($path, $method);
        }

        return $operations;
    }

    private function normalizePath(string $path): string
    {
        if (str_ends_with($path, '.{_format}')) {
            $path = substr($path, 0, -10);
        }

        return $path;
    }
}
