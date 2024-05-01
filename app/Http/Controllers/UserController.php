<?php 

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\RoleServiceInterface;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Models\Person;

class UserController extends Controller 
{
    const VIEW_NAME = 'users';

    function __construct(
        UserServiceInterface   $service, 
        PersonServiceInterface $personService,
        RoleServiceInterface   $roleService
    ) 
    {
        $this->service = $service;
        $this->personService = $personService;
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        $users = $this->service->getAllPaginated();
        return view(self::VIEW_NAME.'.'.'index', compact('users'));
    }

    public function create(): View
    {
        $roles = ArrayHelper::handle1($this->roleService->getAll(), ['id', 'role']);
        return view(self::VIEW_NAME.'.'.'create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {   
        try
        {
            $user = $this->service->storeUser($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-created');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(User $user): View
    {
        return view(self::VIEW_NAME.'.'.'show', compact('user'));
    }

    public function edit(User $user): View
    {
        $viewData = clone $user; 
        $viewData->roles = ArrayHelper::handle1($this->roleService->getAll(), ['id', 'role']);
        $viewData->selectedRoleIds = array_column($user->roles->toArray(), 'id');
        return view(self::VIEW_NAME.'.'.'update', compact('viewData'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        try
        {
            $user = $this->service->updateUser($user, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-updated');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(User $user): RedirectResponse
    {
        try
        {
            $deleted = $this->service->delete($user);
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-deleted');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }
}