<?php 

namespace App\Repositories;

use App\Models\Department;

class DepartmentRepository extends BaseRepository 
{
    function __construct(Department $model)
    {
        parent::__construct($model);
    }
}