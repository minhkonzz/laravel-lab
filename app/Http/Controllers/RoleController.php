<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\RoleServiceInterface;
use App\Models\Role;

class RoleController extends Controller
{
    const VIEW_NAME = 'roles';

    function __construct(RoleServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $roles = $this->service->getAllPaginated();
        return view(self::VIEW_NAME.'.'.'index', compact('roles'));
    }

    public function create(): View
    {
        return view(self::VIEW_NAME.'.'.'create');
    }

    public function store(Request $request): RedirectResponse
    {
        try
        {
            $role = $this->service->storeRole($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'role-created');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(Role $role): View
    {
        return view(self::VIEW_NAME.'.'.'show', compact('role'));
    }

    public function edit(Role $role): View
    {
        return view(self::VIEW_NAME.'.'.'update', compact('role'));
    }

    public function update(Request $request, Role $role): RedirectResponse
    {
        try
        {
            $role = $this->service->updateRole($role, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'role-updated');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Role $role): RedirectResponse
    {
        try
        {
            $deleted = $this->service->delete($role);
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'role-deleted');
        }   
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }
}
