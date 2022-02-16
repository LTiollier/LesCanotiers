<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use WebId\Flan\Filters\Base\FilterFactory;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
    }

    public function index(): Response
    {
        $this->middleware('role:' . User::_ROLE_ADMIN);

        return Inertia::render('User/UserIndex', [
            'filterConfigs' => FilterFactory::create('users')->getConfiguration()
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('User/UserCreate', [
            'roles' => formatForSelect(User::ROLES)
        ]);
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        $this->middleware('role:' . User::_ROLE_ADMIN);

        $this->userRepository->create($request->validated());

        return redirect()->route('users.index');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('User/UserEdit', [
            'user' => UserResource::make($user),
            'roles' => formatForSelect(User::ROLES)
        ]);
    }

    public function update(User $user, StoreUserRequest $request): RedirectResponse
    {
        $this->userRepository->update($user, $request->validated());

        return redirect()->route('users.index');
    }

    /**
     * @throws \Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $this->middleware('role:' . User::_ROLE_ADMIN);

        /** @var User $auth */
        $auth = auth()->user();
        if ($auth->getKey() === $user->getKey()) {
            Auth::logout();
        }

        $this->userRepository->delete($user);

        return redirect()->route('users.index');
    }
}
