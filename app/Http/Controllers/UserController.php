<?php 

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
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
        UserService $service, 
        PersonService $personService,
        RoleService $roleService
    ) 
    {
        parent::__construct($service, self::VIEW_NAME);
        $this->personService = $personService;
        $this->roleService = $roleService;
    }

    public function index(): View
    {
        $users = User::paginate(2);
        return view(self::VIEW_NAME.'.'.'index', compact('users'));
    }

    public function create(): View
    {
        $roles = ArrayHelper::handle1($this->roleService->getAll(), ['id', 'role']);
        return view(self::VIEW_NAME.'.'.'create', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {   
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $user = $this->service->create([
            'name'     => strip_tags($validated['name']),
            'email'    => strip_tags($validated['email']),
            'password' => strip_tags($validated['password'])
        ]);

        $person = new Person;
        $user->person()->save($person);
        $user->roles()->attach($request->input('roles'));
        
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-created');
    }

    public function showUser(User $user): View
    {
        return parent::show($user);
    }

    public function editUser(User $user): View
    {
        $viewData = clone $user; 
        $viewData->roles = ArrayHelper::handle1($this->roleService->getAll(), ['id', 'role']);
        $viewData->selectedRoleIds = array_column($user->roles->toArray(), 'id');
        return parent::edit($viewData);
    }

    public function updateUser(Request $request, User $user): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users' 
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $user = $this->service->update([
            'name'  => strip_tags($validated['name']),
            'email' => strip_tags($validated['email'])
        ], $user);

        $roles = $request->input('roles');
        $user->roles()->sync($roles);

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-updated');
    }

    public function destroyUser(User $user): RedirectResponse
    {
        $this->service->delete($user);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'user-deleted');
    }
}