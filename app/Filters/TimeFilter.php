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
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.times');
    }
}
