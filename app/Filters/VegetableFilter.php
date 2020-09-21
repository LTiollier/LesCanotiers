<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\Vegetable;

class VegetableFilter extends Filter
{
    /**
     * @param Vegetable $model
     */
    public function __construct(Vegetable $model)
    {
        parent::__construct($model);

        $this->setDefinition('vegetableCategory', [
            'mutation' => [
                'type' => 'concat'
            ],
            'table' => 'vegetable_categories',
            'column_name' => 'name',
            'join' => 'joinVegetableCategories',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.vegetables');
    }

    protected function joinVegetableCategories(): void
    {
        $this->query->leftJoin(
            'vegetable_categories',
            $this->model->getTable() . '.vegetable_category_id',
            '=',
            'vegetable_categories.id'
        );
    }
}
