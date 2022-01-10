<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle;

use Shopping\ApiTKCommonBundle\DependencyInjection\ShoppingApiTKCommonBundleExtension;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ShoppingApiTKCommonBundle extends Bundle
{
    public function getContainerExtension(): ?ExtensionInterface
    {
        return new ShoppingApiTKCommonBundleExtension();
    }
}
