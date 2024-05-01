<?php 

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\RoleServiceInterface;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Models\Role;

class RoleService extends BaseService implements RoleServiceInterface
{
    function __construct()
    {
        parent::__construct();
    }

    public function storeRole(array $requestData): Role
    {
        $validator = Validator::make($requestData, [
            'role'        => 'required|string|unique:roles',
            'description' => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        $attributes = [
            'role'        => strip_tags($validated['role']),
            'description' => strip_tags($validated['description']) 
        ];

        return parent::store($attributes);
    }

    public function updateRole(Role $role, array $requestData): Role
    {
        $validator = Validator::make($requestData, [
            'role'        => 'required|string',
            'description' => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        $attributes = [
            'role'        =>  strip_tags($validated['role']),
            'description' =>  strip_tags($validated['description'])
        ];

        return parent::update($role, $attributes);
    }

    protected function getRepositoryClass(): string
    {
        return RoleRepositoryInterface::class;
    }   
}