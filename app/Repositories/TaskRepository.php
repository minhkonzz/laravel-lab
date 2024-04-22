<?php 

namespace App\Repositories;

use App\Models\Task;

class TaskRepository extends BaseRepository
{
    function __construct (Task $task)
    {
        parent::__construct($task);
    }
}