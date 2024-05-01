<?php 

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Services\Interfaces\TaskServiceInterface;
use App\Models\Task;

class TaskService extends BaseService implements TaskServiceInterface
{
    function __construct ()
    {
        parent::__construct();
    }

    public function storeTask(array $requestData): Task
    {
        $validator = Validator::make($requestData, [
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date',
            'priority'     => 'required|string',
            'status'       => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        $project_id = intval(base64_decode($requestData['project']));

        if ($project_id)
        {
            $validated['project_id'] = $project_id;
        }

        $person_id = intval(base64_decode($requestData['person']));

        if ($person_id)
        {
            $validated['person_id'] = $person_id;   
        }

        return $this->repository->createTask($validated);
    }

    public function updateTask(Task $task, array $requestData): Task
    {
        $validator = Validator::make($requestData, [
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date',
            'priority'     => 'required|string',
            'status'       => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        
        $project_id = intval(base64_decode($requestData['project']));
        
        if ($project_id)
        {
            $validated['project_id'] = $project_id;
        }

        $person_id = intval(base64_decode($requestData['person']));

        if ($person_id)
        {
            $validated['person_id'] = $person_id;   
        }

        return $this->repository->updateTask($task, $validated);
    }

    public function filter(Request $request): array
    {
        $requestData = $request->all();
        $selections = ['priorities', 'statuses', 'companies', 'projects'];
        foreach($selections as $selection)
        {
            if (isset($requestData[$selection]))
            {
                $requestData[$selection] = array_map(fn($item) => base64_decode($item), $requestData[$selection]);
            }
        }

        $filteredTasks = $this->repository->filter($requestData);

        return array_merge(
            ['tasks' => $this->repository->getPaginated($filteredTasks, $request->url(), $request->query())],
            ...array_map(fn($item) => ['selected'.ucfirst($item) => $requestData[$item]], array_keys($requestData))
        );
    }

    protected function getRepositoryClass(): string
    {
        return TaskRepositoryInterface::class;
    }
}