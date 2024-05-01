<?php 

namespace App\Repositories;

use Illuminate\Support\Collection;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Models\Task;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    function __construct (Task $task)
    {
        parent::__construct($task);
    }

    public function createTask(array $data): Task
    {
        $task = $this->model->make([
            'name'         => strip_tags($data['name']),
            'start_time'   => strip_tags($data['start_time']), 
            'end_time'     => strip_tags($data['end_time']),
            'priority'     => base64_decode(strip_tags($data['priority'])),
            'status'       => base64_decode(strip_tags($data['status'])),
            'description'  => strip_tags($data['description'])
        ]);

        if (isset($data['project_id']) && !empty($data['project_id']))
        {
            $task->project()->associate($data['project_id']);
        }

        if (isset($data['person_id']) && !empty($data['person_id']))
        {
            $task->person()->associate($data['person_id']);
        }

        $task->save();

        return $task;
    }

    public function updateTask(Task $task, array $data): Task
    {
        $task->update([
            'name'         =>  strip_tags($data['name']),
            'start_time'   =>  strip_tags($data['start_time']), 
            'end_time'     =>  strip_tags($data['end_time']),
            'priority'     =>  base64_decode(strip_tags($data['priority'])),
            'status'       =>  base64_decode(strip_tags($data['status'])),
            'description'  =>  strip_tags($data['description'])
        ]);

        if (isset($data['project_id']) && !empty($data['project_id']))
        {
            $task->project()->associate($data['project_id']);
        }

        if (isset($data['person_id']) && !empty($data['person_id']))
        {
            $task->person()->associate($data['person_id']);
        }

        $task->save();
        
        return $task;
    }

    public function filter(array $data): Collection
    {
        $query = $this->model->getQuery();

        if (isset($data['priorities'])) 
        {
            $query->whereIn('priority', $data['priorities']);
        }

        if (isset($data['statuses'])) 
        {
            $query->whereIn('status', $data['statuses']);
        }

        if (isset($data['companies'])) 
        {
            $query->whereHas('project.company', function ($q) use ($data) {
                $q->whereIn('id', $data['companies']);
            });
        }

        if (isset($data['projects'])) 
        {
            $query->whereIn('project_id', $data['projects']); 
        }

        return $query->get();
    }
}