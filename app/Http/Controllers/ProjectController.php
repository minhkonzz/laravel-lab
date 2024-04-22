<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\ProjectService;
use App\Services\CompanyService;
use App\Models\Project;

class ProjectController extends CRUDController
{
    const VIEW_NAME = 'projects';

    function __construct(ProjectService $service, CompanyService $companyService)
    {
        parent::__construct($service, self::VIEW_NAME);
        $this->companyService = $companyService;
    }

    public function create(): View
    {
        $companies = $this->companyService->getAll();
        return view(self::VIEW_NAME.'.'.'create', compact('companies'));
    }    

    public function storeProject(Request $request): RedirectResponse
    {
        $project = $this->service->create($request->only(['code', 'name', 'description', 'company_id']));
        $personIds = $request->input('person_ids', []);
        $project->person()->sync($personIds);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-created');
    }

    public function showProject(Project $project): View
    {
        return parent::show($project);
    }

    public function editProject(Project $project): View
    {
        $companies = $this->companyService->getAll();
        $selectedPersonIds = $project->people->pluck('id')->toArray();
        return view(self::VIEW_NAME.'.'.'edit', compact('companies', 'project', 'selectedPersonIds'));
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $project->update($request->only(['code', 'name', 'description', 'company_id']));
        $personIds = $request->input('person_ids', []);
        $project->person()->sync($personIds);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-updated');
    }

    public function destroyProject(Project $project): RedirectResponse
    {
        $project->delete();
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-deleted');
    }
}
