<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\CRUD\HasCreate;
use App\Http\Controllers\Traits\CRUD\HasDestroy;
use App\Http\Controllers\Traits\CRUD\HasEdit;
use App\Http\Controllers\Traits\CRUD\HasIndex;
use App\Http\Controllers\Traits\CRUD\HasStore;
use App\Http\Controllers\Traits\CRUD\HasUpdate;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    use HasCreate, HasStore, HasEdit, HasUpdate, HasDestroy, HasIndex {
        HasIndex::index as indexTrait;
        HasStore::store as storeTrait;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        $this->middleware('role:' . User::_ROLE_ADMIN);

        return $this->indexTrait();
    }

    public function store()
    {
        $this->middleware('role:' . User::_ROLE_ADMIN);

        return $this->storeTrait();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $this->middleware('role:' . User::_ROLE_ADMIN);

        $modelName = $this->getSingularModelName();
        $model = $request->$modelName;

        $this->getRepository()->delete($model);

        /** @var User $user */
        $user = auth()->user();
        if ($user->getKey() === $model->getKey()) {
            Auth::logout();
        }

        return redirect()->route(Str::plural($this->getSingularModelName()) . '.index');
    }

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
     * @return array
     */
    protected function additionalProps(): array
    {
        return [
            'roles' => formatForSelect(User::ROLES)
        ];
    }
}
