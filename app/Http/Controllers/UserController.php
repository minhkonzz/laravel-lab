<?php 

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\UserService;
use App\Services\PersonService;
use App\Services\RoleService;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
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
        return view(self::VIEW_NAME.'.'.'create', compact('roles'));
    }

    public function storeUser(StoreUserRequest $request): RedirectResponse
    {   
        $user = $this->service->create(
            $request->only(['name', 'email', 'password'])
        );

        $person = new Person();

        $user->roles()->attach($request->input('selected'));
        $user->person()->save($person);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-created');
    }

    public function showUser(User $user): View
    {
        return parent::show($user);
    }

    public function editUser(User $user): View
    {
        $viewData = clone $user; 
        $viewData->roles = $this->roleService->getAll();
        $viewData->selectedRoleIds = array_column($user->roles->toArray(), 'id');
        return parent::edit($viewData);
    }

    public function updateUser(UpdateUserRequest $request, int $id): RedirectResponse
    {
        $user = $this->service->update($request->only(['name', 'email']), $id);
        $selectedRoles = $request->input('selected');
        $user->roles()->sync($selectedRoles);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-updated');
    }
}