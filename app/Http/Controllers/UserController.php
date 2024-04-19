<?php 

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\UserService;
use App\Services\PersonService;
use App\Services\RoleService;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use App\Models\Person;

class UserController extends CRUDController 
{
    const VIEW_NAME = 'users';

    function __construct (
        UserService $userService, 
        PersonService $personService,
        RoleService $roleService
    ) 
    {
        parent::__construct($userService, self::VIEW_NAME);
        $this->personService = $personService;
        $this->roleService = $roleService;
    }

    public function create(): View
    {
        $roles = $this->roleService->getAll();
        return view(SELF::VIEW_NAME.'.'.'create', compact('roles'));
    }

    public function storeUser(StoreUserRequest $request): RedirectResponse
    {   
        $user = $this->service->create(
            $request->only(['name', 'email', 'password', 'is_active'])
        );

        $person = new Person();

        $user->roles()->attach($request->input('roles'));
        $user->person()->save($person);
        return redirect()->route('users.index');
    }

    public function showUser(User $user): View
    {
        return parent::show($user);
    }

    public function editUser(User $user): View
    {
        return parent::edit($user);
    }

    public function updateUser(StoreUserRequest $request, int $id): RedirectResponse
    {
        $this->service->update($request->only(['email', 'password', 'is_active']), $id);
        return redirect()->route('person.index')->with('success', 'Person updated');
    }
}