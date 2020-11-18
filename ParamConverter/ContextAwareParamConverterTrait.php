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
     */
    protected function initialize(Request $request, ParamConverter $configuration): void
    {
        $this->request = $request;
        $this->configuration = $configuration;
        $this->options = new ParameterBag($configuration->getOptions());
    }

    protected function getConfiguration(): ParamConverter
    {
        return $this->configuration;
    }

    protected function getRequest(): Request
    {
        return $this->request;
    }

    public function getOptions(): ParameterBag
    {
        return $this->options;
    }

    /**
     * @param null $defaultValue
     *
     * @return mixed|null
     */
    protected function getOption(string $optionName, $defaultValue = null)
    {
        return $this->getOptions()->has($optionName) ? $this->getOptions()->get($optionName) : $defaultValue;
    }
}
