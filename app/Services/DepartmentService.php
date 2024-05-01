<?php 

namespace App\Services;

use App\Repositories\Interfaces\DepartmentRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
use App\Services\Interfaces\DepartmentServiceInterface;
use App\Models\Department;
use App\Models\Company;

class DepartmentService extends BaseService implements DepartmentServiceInterface
{
    function __construct()
    {
        parent::__construct();
    }

    public function storeDepartment(Company $company, array $requestData): Department
    {
        $validator = Validator::make($requestData, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:departments'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $validated['company_id'] = $company->id;
        $parent_department_id = intval(base64_decode($requestData['parent_department']));

        if ($parent_department_id)
        {
            $validated['parent_department_id'] = $parent_department_id;
        }

        return $this->repository->createDepartment($validated);
    } 

    public function updateDepartment(Department $department, array $requestData): Department
    {
        $validator = Validator::make($requestData, [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $parent_department_id = intval(base64_decode($requestData['parent_department']));

        if ($parent_department_id)
        {
            $validated['parent_department_id'] = $parent_department_id;
        }

        return $this->repository->updateDepartment($department, $validated);
    }

    protected function getRepositoryClass(): string
    {
        return DepartmentRepositoryInterface::class;
    }
}