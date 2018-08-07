<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

/**
 * Class ValidationException.
 *
 * @package Shopping\ApiTKCommonBundle\Exception
 *
 * @author Alexander Dormann <alexander.dormann@check24.de>
 */
class ValidationException extends BadRequestHttpException
{
}
