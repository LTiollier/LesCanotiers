<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreActivityRequest;
use App\Http\Resources\ActivityResource;
use App\Models\Activity;
use App\Repositories\ActivityRepository;

class ActivityController extends ResourceControllerAbstract
{
    protected function getRepository()
    {
        return app(ActivityRepository::class);
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'Activity/Activity';
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'activity';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreActivityRequest::class;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return Activity::class;
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
        return ActivityResource::class;
    }
}
