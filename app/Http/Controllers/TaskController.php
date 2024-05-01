<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;
use App\Helpers\ArrayHelper;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Services\Interfaces\ProjectServiceInterface;
use App\Exports\TaskExport;
use App\Models\Task;
use App\Models\Person;

class TaskController extends Controller
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
        TaskServiceInterface    $service, 
        CompanyServiceInterface $companyService, 
        ProjectServiceInterface $projectService
    )
    {
        $this->service = $service;
        $this->companyService = $companyService;
        $this->projectService = $projectService;
    }

    public function index(): View
    {
        $tasks = $this->service->getAllPaginated();
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
        try
        {
            $task = $this->service->storeTask($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-created');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }
    
    public function edit(Task $task): View
    {
        $viewData = clone $task;
        $viewData->projects = ArrayHelper::handle1($this->projectService->getAll());
        $viewData->priorities = self::$priorities;
        $viewData->statuses = self::$statuses;
        return view(self::VIEW_NAME.'.'.'update', compact('viewData'));
    }

    public function show(Task $task): View
    {
        $viewData = clone $task;
        $viewData->priorities = self::$priorities;
        $viewData->statuses = self::$statuses;
        return view(self::VIEW_NAME.'.'.'show', compact('viewData'));
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        try
        {
            $task = $this->service->updateTask($task, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-updated');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Task $task): RedirectResponse
    {
        try 
        {
            $deleted = $this->service->delete($task);
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'task-deleted');
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage());
        }
    }

    public function filter(Request $request): View
    {
        try
        {
            $companies = ArrayHelper::handle1($this->companyService->getAll());
            $projects = ArrayHelper::handle1($this->projectService->getAll());
            $res = $this->service->filter($request);
            return view(self::VIEW_NAME.'.'.'index', array_merge($res, [
                'companies'  => $companies,
                'projects'   => $projects,
                'priorities' => self::$priorities,
                'statuses'   => self::$statuses,
            ]));
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }

    public function export()
    {
        return Excel::download(new TaskExport, self::VIEW_NAME.'.'.'xlsx');
    }
}
