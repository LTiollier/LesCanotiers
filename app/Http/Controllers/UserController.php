<?php

namespace App\Http\Controllers;

use App\Filters\Base\FilterFactory;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class UserController extends Controller
{
    /** @var \App\Repositories\UserRepository  */
    protected $userRepository;

    /**
     * @param \App\Repositories\UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('User/UserIndex', [
            'filterConfigs' => FilterFactory::create('users')->getConfiguration()
        ]);
    }

    /**
     * @return \Inertia\Response
     */
    public function create()
    {
        return Inertia::render('User/UserCreate');
    }

    /**
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $this->userRepository->create($request->validated());
        return redirect()->route('users.index');
    }

    /**
     * @param \App\Models\User $user
     * @return \Inertia\Response
     */
    public function edit(User $user)
    {
        return Inertia::render('User/UserEdit', [
            'user' => UserResource::make($user),
        ]);
    }

    /**
     * @param \App\Models\User $user
     * @param \App\Http\Requests\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(User $user, StoreUserRequest $request)
    {
        $this->userRepository->update($user, $request->validated());
        return redirect()->route('users.index');
    }

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(User $user)
    {
        $this->userRepository->delete($user);
        /** @var user $user */
        $user = auth()->user();
        if ($user->getKey() === $user->getKey()) {
            Auth::logout();
        }
        return redirect()->route('users.index');
    }
}
