<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager;

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
        return $this->getOption('entity', null);
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager|null
     */
    protected function getManager(): ?ObjectManager
    {
        $name = $this->getOption('entityManager', null);

        if (null === $name) {
            return $this->registry->getManagerForClass($this->getEntity());
        }

        return $this->registry->getManager($name);
    }

    /**
     * @param string|null $defaultName
     *
     * @return null|string
     */
    protected function getRepositoryMethodName(string $defaultName = null): ?string
    {
        return $this->getOption('methodName', $defaultName);
    }

    /**
     * Call a given method on an EntityRepository.
     *
     * @param string $method
     * @param mixed  ...$args
     *
     * @return mixed
     */
    protected function callRepositoryMethod(string $method, ...$args)
    {
        $om = $this->getManager();
        $repo = $om->getRepository($this->getEntity());

        if (!method_exists($repo, $method) || !is_callable([$repo, $method])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Method "%s" doesn\'t exist or isn\'t callable in EntityRepository "%s"',
                    $method,
                    get_class($repo)
                )
            );
        }

        return $repo->$method($args);
    }
}
