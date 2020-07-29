<?php

namespace App\Filters;

use App\Filters\Base\Filter;
use App\Models\User;

class UserFilter extends Filter
{
    /**
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    /**
     * @return array<string, mixed>
     */
    public function getConfiguration(): array
    {
        return config('filters.users');
    }
}
