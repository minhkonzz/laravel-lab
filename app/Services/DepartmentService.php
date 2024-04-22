<?php 

namespace App\Services;

use App\Repositories\DepartmentRepository;

class DepartmentService extends BaseService
{
    function __construct(DepartmentRepository $repository)
    {
        parent::__construct($repository);
    }
}