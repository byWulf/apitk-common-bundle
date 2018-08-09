<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trait ContextAwareParamConverterTrait.
 *
 * @package Shopping\ApiTKCommonBundle\ParamConverter
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
trait ContextAwareParamConverterTrait
{
    /**
     * @var ParamConverter
     */
    protected $configuration;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Set request and configuration context as class properties for easy access.
     *
     * @param Request        $request
     * @param ParamConverter $configuration
     */
    protected function initialize(Request $request, ParamConverter $configuration): void
    {
        $this->setRequest($request);
        $this->setConfiguration($configuration);
    }

    /**
     * @return ParamConverter
     */
    protected function getConfiguration(): ParamConverter
    {
        return $this->configuration;
    }

    /**
     * @param ParamConverter $configuration
     *
     * @return ContextAwareParamConverterTrait
     */
    protected function setConfiguration(ParamConverter $configuration): ContextAwareParamConverterTrait
    {
        $this->configuration = $configuration;

        return $this;
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     *
     * @return ContextAwareParamConverterTrait
     */
    protected function setRequest(Request $request): ContextAwareParamConverterTrait
    {
        $this->request = $request;

        return $this;
    }
}
