<?php 

namespace App\Repositories\Interfaces;

use App\Models\Department;

interface DepartmentRepositoryInterface 
{
    public function createDepartment(array $data): Department;
    public function updateDepartment(Department $department, array $data): Department; 
}