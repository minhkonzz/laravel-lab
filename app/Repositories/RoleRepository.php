<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository extends BaseRepository
{
    function __construct(Role $model) 
    {
        parent::__construct($model);    
    }
}