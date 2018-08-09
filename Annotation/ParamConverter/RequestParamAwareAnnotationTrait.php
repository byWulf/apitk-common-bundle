<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Annotation;

/**
 * Trait RequestParamAwareAnnotationTrait.
 *
 * @package Shopping\ApiTKCommonBundle\Annotation
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
trait RequestParamAwareAnnotationTrait
{
    /**
     * @param $requestParam
     */
    public function setRequestParam($requestParam)
    {
        $options = $this->getOptions();
        $options['requestParam'] = $requestParam;

        $this->setOptions($options);
    }
}
