<?php 

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService extends BaseService
{
    function __construct (TaskRepository $repository)
    {
        parent::__construct($repository);
    }
}