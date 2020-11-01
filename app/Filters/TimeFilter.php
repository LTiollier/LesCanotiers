<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\Time;

class TimeFilter extends Filter
{
    /**
     * @param Time $model
     */
    public function __construct(Time $model)
    {
        parent::__construct($model);

        $this->setDefinition('user', [
            'custom_select' => "users.name",
            'table' => 'users',
            'join' => 'joinUser',
        ]);

        $this->setDefinition('activity', [
            'custom_select' => "activities.name",
            'table' => 'activities',
            'join' => 'joinActivity',
        ]);

        $this->setDefinition('cycle_date', [
            'custom_select' => "CONCAT_WS(
                ' au ',
                DATE_FORMAT(`cycles`.`starts_at`, '%d/%m/%Y'),
                DATE_FORMAT(`cycles`.`ends_at`, '%d/%m/%Y')
            )",
            'join' => 'joinCycle',
            'table' => 'cycle',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.times');
    }

    protected function joinUser(): void
    {
        $this->query->leftJoin(
            'users',
            $this->model->getTable() . '.user_id',
            '=',
            'users.id'
        );
    }

    protected function joinActivity(): void
    {
        $this->query->leftJoin(
            'activities',
            $this->model->getTable() . '.activity_id',
            '=',
            'activities.id'
        );
    }

    protected function joinCycle(): void
    {
        $this->query->leftJoin(
            'cycles',
            $this->model->getTable() . '.cycle_id',
            '=',
            'cycles.id'
        );
    }
}
