<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Symfony\Component\HttpFoundation\Request;

/**
 * Trait RequestParamAwareParamConverterTrait.
 *
 * @package Shopping\ApiTKCommonBundle\ParamConverter
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
trait RequestParamAwareParamConverterTrait
{
    use ContextAwareParamConverterTrait;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param string|null $defaultValue
     * @param string      $defaultName
     *
     * @return null|string
     */
    protected function getRequestParamValue(string $defaultValue = null, string $defaultName = 'id'): ?string
    {
        $paramName = $this->getRequestParamName($defaultName);

        return $this->request->get($paramName, $defaultValue);
    }

    /**
     * @param string $defaultName
     *
     * @return string
     */
    protected function getRequestParamName(string $defaultName = 'id'): ?string
    {
        return $this->getOption('requestParam', $defaultName);
    }
}
