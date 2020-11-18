<?php

declare(strict_types=1);

namespace Shopping\ApiTKCommonBundle\Describer;

use EXSyst\Component\Swagger\Schema;
use function in_array;
use MyCLabs\Enum\Enum;
use Nelmio\ApiDocBundle\Model\Model;
use Nelmio\ApiDocBundle\ModelDescriber\ModelDescriberInterface;
use Symfony\Component\PropertyInfo\Type;

class EnumDescriber implements ModelDescriberInterface
{
    public function describe(Model $model, Schema $schema): void
    {
        $className = $model->getType()->getClassName();
        $schema->setType('enum');
        $schema->setEnum(array_values($className::toArray()));
    }

    public function supports(Model $model): bool
    {
        if ($model->getType()->getBuiltinType() !== Type::BUILTIN_TYPE_OBJECT) {
            return false;
        }

        return in_array(Enum::class, class_parents(
            $model->getType()->getClassName()
        ));
    }
}
