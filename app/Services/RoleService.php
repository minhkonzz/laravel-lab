<?php 

namespace App\Services;

use App\Repositories\RoleRepository;

class RoleService extends BaseService
{
    function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }
}