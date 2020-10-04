<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends ResourceControllerAbstract
{
    protected function getRepository()
    {
        return app(UserRepository::class);
    }

    /**
     * @return string
     */
    protected function getInertiaComponentTemplate(): string
    {
        return 'User/User';
    }

    /**
     * @return string
     */
    protected function getSingularModelName(): string
    {
        return 'user';
    }

    /**
     * @return string
     */
    protected function getStoreRequestClass(): string
    {
        return StoreUserRequest::class;
    }

    /**
     * @return string
     */
    protected function getModelClass(): string
    {
        return User::class;
    }

    /**
     * @return string
     */
    protected function getModelResourceClass(): string
    {
        return UserResource::class;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(Request $request)
    {
        $modelName = $this->getSingularModelName();
        $model = $request->$modelName;

        $this->getRepository()->delete($model);

        /** @var User $user */
        $user = auth()->user();
        if ($user->getKey() === $model->getKey()) {
            Auth::logout();
        }

        return redirect()->route($this->getPluralModelName() . '.index');
    }
}
