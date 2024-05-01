<?php

namespace App\Services\Interfaces;

use App\Models\Role;

interface RoleServiceInterface
{
    public function storeRole(array $requestData): Role;
    public function updateRole(Role $role, array $requestData): Role;
}