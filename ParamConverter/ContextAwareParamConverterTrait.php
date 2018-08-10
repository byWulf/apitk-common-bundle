<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
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
     * @var ParameterBag
     */
    protected $options;

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
        $this->request = $request;
        $this->configuration = $configuration;
        $this->options = new ParameterBag($configuration->getOptions());
    }

    /**
     * @return ParamConverter
     */
    protected function getConfiguration(): ParamConverter
    {
        return $this->configuration;
    }

    /**
     * @return Request
     */
    protected function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @return ParameterBag
     */
    public function getOptions(): ParameterBag
    {
        return $this->options;
    }

    /**
     * @param string $optionName
     * @param null   $defaultValue
     *
     * @return mixed|null
     */
    protected function getOption(string $optionName, $defaultValue = null)
    {
        return $this->getOptions()->has($optionName) ? $this->getOptions()->get($optionName) : $defaultValue;
    }
}
