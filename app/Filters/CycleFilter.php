<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\Cycle;

class CycleFilter extends Filter
{
    /**
     * @param Cycle $model
     */
    public function __construct(Cycle $model)
    {
        parent::__construct($model);

        $this->setDefinition('vegetable', [
            'custom_select' => "vegetables.name",
            'table' => 'vegetables',
            'join' => 'joinVegetable',
        ]);

        $this->setDefinition('parcel', [
            'custom_select' => "parcels.name",
            'table' => 'parcels',
            'join' => 'joinParcel',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.cycles');
    }

    protected function joinVegetable(): void
    {
        $this->query->leftJoin(
            'vegetables',
            $this->model->getTable() . '.vegetable_id',
            '=',
            'vegetables.id'
        );
    }

    protected function joinParcel(): void
    {
        $this->query->leftJoin(
            'parcels',
            $this->model->getTable() . '.parcel_id',
            '=',
            'parcels.id'
        );
    }
}
