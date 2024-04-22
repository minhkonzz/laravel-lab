<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TaskService;
use App\Services\CompanyService;
use App\Services\ProjectService;
use App\Models\Task;

class TaskController extends CRUDController
{
    const VIEW_NAME = 'tasks';

    function __construct (
        TaskService $service, 
        CompanyService $companyService, 
        ProjectService $projectService
    )
    {
        parent::__construct($service, self::VIEW_NAME);
        $this->companyService = $companyService;
        $this->projectService = $projectService;
    }

    public function index(): View
    {
        $tasks = $this->service->getAll();
        $companies = $this->companyService->getAll();
        $projects = $this->projectService->getAll();
        return view(self::VIEW_NAME.'.'.'index', compact('tasks', 'companies', 'projects'));
    }

    public function storeTask(Request $request): RedirectResponse
    {
        $task = $this->service->create($request->only([
            'name', 
            'start_time', 
            'end_time', 
            'priority', 
            'status', 
            'description', 
            'project_id'
        ]));

        $personIds = $request->input('person_ids', []);
        $task->person()->sync($personIds);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-created');
    }
    
    public function editTask(Task $task): View
    {
        return parent::edit($task);
    }

    public function showTask(Task $task): View
    {
        return parent::show($task);
    }

    public function destroyTask(Task $task): RedirectResponse
    {
        $task->delete();
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-deleted');
    }
}
