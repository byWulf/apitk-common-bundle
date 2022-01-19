<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class ShoppingApiTKCommonBundleExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \Exception
     * @phpstan-ignore-next-line
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));
        $loader->load('services.yaml');
    }
}
