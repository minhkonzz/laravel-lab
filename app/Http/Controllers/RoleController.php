<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\RoleService;
use App\Models\Role;

class RoleController extends CRUDController
{
    const VIEW_NAME = 'roles';

    function __construct(RoleService $service)
    {
        parent::__construct($service, self::VIEW_NAME);
    }

    public function index(): View
    {
        $roles = Role::paginate(2);
        return view(self::VIEW_NAME.'.'.'index', compact('roles'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'role'        => 'required|string|unique:roles|alpha_dash',
            'description' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $role = $this->service->create([
            'role'        => strip_tags($validated['role']),
            'description' => strip_tags($validated['description']) 
        ]);

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'role-created');
    }

    public function showRole(Role $role): View
    {
        return parent::show($role);
    }

    public function editRole(Role $role): View
    {
        return parent::edit($role);
    }

    public function updateRole(Request $request, Role $role): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'role'        => 'required|string|unique:roles|alpha_dash',
            'description' => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $role = $this->service->update([
            'role'        =>  strip_tags($validated['role']),
            'description' =>  strip_tags($validated['description'])
        ], $role);

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'role-updated');
    }

    public function destroyRole(Role $role): RedirectResponse
    {
        $this->service->delete($role);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'role-deleted');
    }
}
