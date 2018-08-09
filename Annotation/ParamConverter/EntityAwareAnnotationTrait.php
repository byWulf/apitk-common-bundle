<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Annotation;

/**
 * Trait EntityAwareAnnotationTrait.
 *
 * @package Shopping\ApiTKCommonBundle\Annotation
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
trait EntityAwareAnnotationTrait
{
    /**
     * @param $entityName
     */
    public function setEntity($entityName)
    {
        $options = $this->getOptions();
        $options['entity'] = $entityName;

        $this->setOptions($options);
    }

    /**
     * @param $manager
     */
    public function setEntityManager($manager)
    {
        $options = $this->getOptions();
        $options['entityManager'] = $manager;

        $this->setOptions($options);
    }

    /**
     * @param $methodName
     */
    public function setMethodName($methodName)
    {
        $options = $this->getOptions();
        $options['methodName'] = $methodName;

        $this->setOptions($options);
    }
}
