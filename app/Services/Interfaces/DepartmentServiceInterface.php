<?php 

namespace App\Services\Interfaces;

use App\Models\Company;
use App\Models\Department;

interface DepartmentServiceInterface
{
    public function storeDepartment(Company $company, array $requestData): Department;
    public function updateDepartment(Department $department, array $requestData): Department;
}