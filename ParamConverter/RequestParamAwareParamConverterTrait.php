<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

/**
 * Trait RequestParamAwareParamConverterTrait.
 *
 * @package Shopping\ApiTKCommonBundle\ParamConverter
 */
trait RequestParamAwareParamConverterTrait
{
    /**
     * @var Request
     */
    protected $request;

    protected function getRequestParamValue(string $defaultValue = null, string $defaultName = 'id'): ?string
    {
        $paramName = $this->getRequestParamName($defaultName);

        return $this->request->get($paramName, $defaultValue);
    }

    /**
     * @return string
     */
    protected function getRequestParamName(string $defaultName = 'id'): ?string
    {
        return $this->getOption('requestParam', $defaultName);
    }
}
