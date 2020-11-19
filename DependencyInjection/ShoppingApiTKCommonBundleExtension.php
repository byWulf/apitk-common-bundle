<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * Class ShoppingApiTKCommonBundleExtension.
 *
 * @package Shopping\ApiTKCommonBundle\DependencyInjection
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
class ShoppingApiTKCommonBundleExtension extends Extension
{
    /**
     * Loads a specific configuration.
     *
     * @throws \Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');
    }
}
