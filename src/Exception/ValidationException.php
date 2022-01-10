<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Exception;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ValidationException extends BadRequestHttpException
{
}
