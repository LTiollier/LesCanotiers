<?php

namespace App\Filters\Fields;

use App\Filters\Base\Field;
use App\Filters\Base\FieldContract;
use Illuminate\Database\Query\Builder;

class Select extends Field implements FieldContract
{
    /**
     * @param array<string, string> $search
     * @param string $columnName
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(array $search, string $columnName): Builder
    {
        return $this->query->whereRaw("$columnName = ?", [$search['term']]);
    }

    /**
     * @param string $fieldName
     * @return array<string, string>
     */
    public static function getRules(string $fieldName): array
    {
        return [
            $fieldName => 'array',
            $fieldName .'.term' => 'nullable|string',
        ];
    }
}
