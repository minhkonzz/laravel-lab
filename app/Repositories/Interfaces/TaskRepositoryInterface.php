<?php 

namespace App\Repositories\Interfaces;

use Illuminate\Support\Collection;
use App\Models\Task;

interface TaskRepositoryInterface
{
    public function createTask(array $data): Task;
    public function updateTask(Task $task, array $data): Task;
    public function filter(array $data): Collection;
}