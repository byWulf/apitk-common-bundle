<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Describer;

use EXSyst\Component\Swagger\Schema;
use function in_array;
use Nelmio\ApiDocBundle\Model\Model;
use Nelmio\ApiDocBundle\ModelDescriber\ModelDescriberInterface;
use Symfony\Component\PropertyInfo\Type;

class EnumDescriber implements ModelDescriberInterface
{
    public function describe(Model $model, Schema $schema): void
    {
        $className = $model->getType()->getClassName();
        $schema->setType('enum');
        $schema->setEnum([$className]);
    }

    public function supports(Model $model): bool
    {
        if ($model->getType()->getBuiltinType() !== Type::BUILTIN_TYPE_OBJECT) {
            return false;
        }

        $className = (string) $model->getType()->getClassName();
        $classParents = class_parents($className);

        if (!$classParents) {
            return false;
        }

        /** @phpstan-ignore-next-line  */
        return in_array('MyCLabs\Enum\Enum', $classParents, true);
    }
}
