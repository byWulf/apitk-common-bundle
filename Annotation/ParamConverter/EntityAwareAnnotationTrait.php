<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Annotation\ParamConverter;

use Doctrine\ORM\EntityManagerInterface;

trait EntityAwareAnnotationTrait
{
    public function setEntity(string $entityName): void
    {
        $options = $this->getOptions();
        $options['entity'] = $entityName;

        $this->setOptions($options);
    }

    public function setEntityManager(EntityManagerInterface $manager): void
    {
        $options = $this->getOptions();
        $options['entityManager'] = $manager;

        $this->setOptions($options);
    }

    public function setMethodName(string $methodName): void
    {
        $options = $this->getOptions();
        $options['methodName'] = $methodName;

        $this->setOptions($options);
    }
}
