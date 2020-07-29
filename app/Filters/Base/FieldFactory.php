<?php

namespace App\Filters\Base;

use App\Filters\Fields\Checkbox;
use App\Filters\Fields\Date;
use App\Filters\Fields\Number;
use App\Filters\Fields\Select;
use App\Filters\Fields\Text;
use Illuminate\Database\Query\Builder;

class FieldFactory
{
    /**
     * @param string $type
     * @param Builder $query
     * @return FieldContract
     * @throws \InvalidArgumentException
     */
    public static function create(string $type, Builder $query): FieldContract
    {
        $class = self::getClass($type);

        return new $class($query);
    }

    /**
     * @param string $type
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function getClass(string $type): string
    {
        $fieldTypes = config('filters.field_classes');

        if (isset($fieldTypes[$type])) {
            return $fieldTypes[$type];
        }

        throw new \InvalidArgumentException("FieldContract implementation for '$type' doesn't exist");
    }
}
