<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\ParamConverter;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use InvalidArgumentException;
use Shopping\ApiTKCommonBundle\Exception\MissingDependencyException;

/**
 * Trait EntityAwareParamConverterTrait.
 *
 * @package Shopping\ApiTKCommonBundle\ParamConverter
 */
trait EntityAwareParamConverterTrait
{
    /**
     * @var ManagerRegistry|null
     */
    protected $registry;

    public function setRegistry(ManagerRegistry $registry): void
    {
        $this->registry = $registry;
    }

    protected function getEntity(): ?string
    {
        return $this->getOption('entity', null);
    }

    protected function getManager(): ?ObjectManager
    {
        if ($this->registry === null) {
            return null;
        }

        $name = $this->getOption('entityManager', null);

        if (null === $name) {
            return $this->registry->getManagerForClass($this->getEntity());
        }

        return $this->registry->getManager($name);
    }

    protected function getRepositoryMethodName(string $defaultName = null): ?string
    {
        return $this->getOption('methodName', $defaultName);
    }

    /**
     * Call a given method on an EntityRepository.
     *
     * @param mixed ...$args
     *
     * @return mixed
     */
    protected function callRepositoryMethod(string $method, ...$args)
    {
        $om = $this->getManager();

        if ($om === null) {
            throw new MissingDependencyException('Unable to detect an instance of Doctrine\Persistence\ObjectManager. ' . 'You need to install doctrine/orm and doctrine/doctrine-bundle > 2.0 to use ORM-capabilities within ApiTK bundles.');
        }

        $repo = $om->getRepository($this->getEntity());

        if (!method_exists($repo, $method) || !is_callable([$repo, $method])) {
            throw new InvalidArgumentException(sprintf('Method "%s" doesn\'t exist or isn\'t callable in EntityRepository "%s"', $method, get_class($repo)));
        }

        return $repo->$method(...$args);
    }
}
