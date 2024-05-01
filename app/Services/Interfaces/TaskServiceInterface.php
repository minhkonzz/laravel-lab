<?php 

namespace App\Services\Interfaces;

use Illuminate\Http\Request;
use App\Models\Task;

interface TaskServiceInterface
{
    public function storeTask(array $requestData): Task;
    public function updateTask(Task $task, array $requestData): Task;
    public function filter(Request $request): array;
}