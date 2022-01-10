<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Annotation\ParamConverter;

trait RequestParamAwareAnnotationTrait
{
    public function setRequestParam(string $requestParam): void
    {
        $options = $this->getOptions();
        $options['requestParam'] = $requestParam;

        $this->setOptions($options);
    }
}
