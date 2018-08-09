<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Trait EntityAwareParamConverterTrait.
 *
 * @package Shopping\ApiTKCommonBundle\ParamConverter
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
trait EntityAwareParamConverterTrait
{
    /**
     * @var ManagerRegistry
     */
    protected $registry;

    /**
     * @var ParamConverter
     */
    protected $configuration;

    /**
     * @param ManagerRegistry $registry
     */
    public function setRegistry(ManagerRegistry $registry): void
    {
        $this->registry = $registry;
    }

    /**
     * @return null|string
     */
    protected function getEntity(): ?string
    {
        return $this->configuration->getOptions()['entity'] ?? null;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|null
     */
    protected function getManager(): ?ObjectManager
    {
        $name = $this->configuration->getOptions()['entityManager'] ?? null;

        if (null === $name) {
            return $this->registry->getManagerForClass($this->getEntity());
        }

        return $this->registry->getManager($name);
    }
}
