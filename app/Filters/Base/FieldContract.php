<?php

namespace App\Filters\Base;

use Illuminate\Database\Query\Builder;

interface FieldContract
{
    /**
     * Réalise la requête de type 'where' sur le tableau $search et la colonne $columnName
     *
     * @param array<string, mixed> $search
     * @param string $columnName
     * @return \Illuminate\Database\Query\Builder
     */
    public function query(array $search, string $columnName): Builder;

    /**
     * Retourne les règles de validation de la FormRequest
     *
     * @param string $fieldName
     * @return array<string, array<int, string>|string>
     */
    public static function getRules(string $fieldName): array;
}
