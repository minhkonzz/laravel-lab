<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
use App\Services\Interfaces\ProjectServiceInterface;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Models\Project;

class ProjectController extends Controller
{
    const VIEW_NAME = 'projects';

    function __construct(
        ProjectServiceInterface $service, 
        CompanyServiceInterface $companyService
    )
    {
        $this->service = $service;
        $this->companyService = $companyService;
    }

    public function index(): View
    {
        $projects = $this->service->getAllPaginated();
        return view(self::VIEW_NAME.'.'.'index', compact('projects'));
    }

    public function create(): View
    {
        $companies = ArrayHelper::handle1($this->companyService->getAll(), ['id', 'name']);
        return view(self::VIEW_NAME.'.'.'create', compact('companies'));
    }    

    public function store(Request $request): RedirectResponse
    {
        try
        {
            $project = $this->service->storeProject($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-created');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(Project $project): View
    {
        return view(self::VIEW_NAME.'.'.'show', compact('project'));
    }

    public function edit(Project $project): View
    {
        $viewData = clone $project;
        $viewData->companies = ArrayHelper::handle1($this->companyService->getAll(), ['id', 'name']);
        $viewData->selectedPersonIds = $project->persons->pluck('id')->toArray();
        return view(self::VIEW_NAME.'.'.'update', compact('viewData'));
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        try
        {
            $project = $this->service->updateProject($project, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-updated');   
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Project $project): RedirectResponse
    {
        try 
        {
            $deleted = $this->service->delete($project);
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-deleted');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }

    public function getPersons(Project $project)
    {
        return response()->json($project->persons);
    }
}
