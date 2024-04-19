<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\RoleService;
use App\Models\Role;

class RoleController extends CRUDController
{
    const VIEW_NAME = 'roles';

    function __construct(RoleService $service)
    {
        parent::__construct($service, self::VIEW_NAME);
    }

    public function showRole(Role $role): View
    {
        return parent::show($role);
    }

    public function editRole(Role $role): View
    {
        return parent::edit($role);
    }
}
