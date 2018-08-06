<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle;

use Shopping\ApiTKCommonBundle\DependencyInjection\ShoppingApiTKCommonBundleExtension;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class ShoppingApiTKCommonBundle.
 *
 * @package Shopping\ApiTKCommonBundle
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
class ShoppingApiTKCommonBundle extends Bundle
{
    /**
     * @return ShoppingApiTKCommonBundleExtension
     */
    public function getContainerExtension()
    {
        return new ShoppingApiTKCommonBundleExtension();
    }
}
