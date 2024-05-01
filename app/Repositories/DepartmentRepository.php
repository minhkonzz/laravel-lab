<?php 

namespace App\Repositories;

use App\Models\Department;
use App\Repositories\Interfaces\DepartmentRepositoryInterface;

class DepartmentRepository extends BaseRepository implements DepartmentRepositoryInterface
{
    function __construct(Department $model)
    {
        parent::__construct($model);
    }

    public function createDepartment(array $data): Department
    {
        $department = $this->model->make([
            'code' => strip_tags($data['code']),
            'name' => strip_tags($data['name'])
        ]);

        $department->company()->associate($data['company_id']);

        if (isset($data['parent_department_id']) && !empty($data['parent_department_id'])) 
        {
            $department->parent()->associate($data['parent_department_id']);
        }
        
        $department->save();
        return $department;
    }

    public function updateDepartment(Department $department, array $data): Department
    {
        $department->update([
            'code' => strip_tags($data['code']),
            'name' => strip_tags($data['name'])
        ]);

        if (isset($data['parent_department_id']) && !empty($data['parent_department_id'])) 
        {
            $department->parent()->associate($data['parent_department_id']);
        }

        $department->save();
        return $department;
    }
}