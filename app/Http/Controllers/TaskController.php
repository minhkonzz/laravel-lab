<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ArrayHelper;
use App\Services\TaskService;
use App\Services\CompanyService;
use App\Services\ProjectService;
use App\Exports\TaskExport;
use App\Models\Task;
use App\Models\Person;

class TaskController extends CRUDController
{
    const VIEW_NAME = 'tasks';

    private static $priorities = [
        'pr1' => 'High',
        'pr2' => 'Normal',
        'pr3' => 'Low'
    ];

    private static $statuses = [
        'sta1' => 'Just created',
        'sta2' => 'In progress',
        'sta3' => 'Done',
        'sta4' => 'Pending'
    ];

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
        $tasks = Task::paginate(2);
        $companies = ArrayHelper::handle1($this->companyService->getAll());
        $projects = ArrayHelper::handle1($this->projectService->getAll());

        return view(self::VIEW_NAME.'.'.'index', [
            'tasks'      =>  $tasks,
            'companies'  =>  $companies,
            'projects'   =>  $projects,
            'priorities' =>  self::$priorities,
            'statuses'   =>  self::$statuses
        ]);
    }

    public function create(): View
    {
        $projects = ArrayHelper::handle1($this->projectService->getAll());
        return view(self::VIEW_NAME.'.'.'create', [
            'projects'   =>  $projects,
            'priorities' =>  self::$priorities,
            'statuses'   =>  self::$statuses
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'          => 'required|string',
            'description'   => 'required|string',
            'start_time'    => 'required|date',
            'end_time'      => 'required|date',
            'priority'      => 'required|string',
            'status'        => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $task = Task::make([
            'name'         => strip_tags($validated['name']),
            'start_time'   => strip_tags($validated['start_time']), 
            'end_time'     => strip_tags($validated['end_time']),
            'priority'     => base64_decode(strip_tags($validated['priority'])),
            'status'       => base64_decode(strip_tags($validated['status'])),
            'description'  => strip_tags($validated['description'])
        ]);

        $project_id = intval(base64_decode($request->input('project')));
        $person_id  = intval($request->input('person'));

        $task->project()->associate($project_id);
        $task->person()->associate($person_id);
        $task->save();

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-created');
    }
    
    public function editTask(Task $task): View
    {
        $viewData = clone $task;
        $viewData->projects = ArrayHelper::handle1($this->projectService->getAll());
        $viewData->priorities = self::$priorities;
        $viewData->statuses = self::$statuses;
        return parent::edit($viewData);
    }

    public function showTask(Task $task): View
    {
        $viewData = clone $task;
        $viewData->priorities = self::$priorities;
        $viewData->statuses = self::$statuses;
        return parent::show($viewData);
    }

    public function updateTask(Request $request, Task $task): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date',
            'priority'     => 'required|string',
            'status'       => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $task = $this->service->update([
            'name'         =>  strip_tags($validated['name']),
            'start_time'   =>  strip_tags($validated['start_time']), 
            'end_time'     =>  strip_tags($validated['end_time']),
            'priority'     =>  base64_decode(strip_tags($validated['priority'])),
            'status'       =>  base64_decode(strip_tags($validated['status'])),
            'description'  =>  strip_tags($validated['description'])
        ], $task);

        $project_id = intval(base64_decode($request->input('project')));

        if (!empty($project_id))
        {
            $task->project()->associate($project_id);
        }

        $person_id  = intval($request->input('person'));

        if (!empty($person_id))
        {
            $task->person()->associate($person_id);
        }

        $task->save();

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-updated');
    }

    public function destroyTask(Task $task): RedirectResponse
    {
        $this->service->delete($task);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-deleted');
    }

    public function filter(Request $request): View
    {
        $tasks = DB::table('projects')
            ->join('tasks', 'tasks.project_id', 'projects.id')
            ->join('companies', 'projects.company_id', 'companies.id')
            ->select('tasks.*');

        if ($request->has('priorities')) {
            $tasks = $tasks->whereIn('priority', $request->input('priorities'));
        }

        if ($request->has('statuses')) {
            $tasks = $tasks->whereIn('status', $request->input('statuses'));
        }

        if ($request->has('companies')) {
            $tasks = $tasks->whereIn('companies.id', $request->input('companies'));
        }

        if ($request->has('projects')) {
            $tasks = $tasks->whereIn('projects.id', $request->input('projects'));
        }
        
        $tasks = $tasks->get();
        return view(self::VIEW_NAME.'.'.'index', ['items' => $tasks]);
    }

    public function export()
    {
        return Excel::download(new TaskExport, self::VIEW_NAME.'.'.'xlsx');
    }
}
