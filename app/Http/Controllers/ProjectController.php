<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
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

    public function index(): View
    {
        $projects = Project::paginate(2);
        return view(self::VIEW_NAME.'.'.'index', compact('projects'));
    }

    public function create(): View
    {
        $companies = ArrayHelper::handle1($this->companyService->getAll(), ['id', 'name']);
        return view(self::VIEW_NAME.'.'.'create', compact('companies'));
    }    

    public function store(Request $request): RedirectResponse
    {
        $validato = Validator::make($request->all(), [
            'code'        => 'required|string|unique:projects|alpha_dash',
            'name'        => 'required|string',
            'description' => 'required|string|' 
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $project = Project::make([
            'code'         =>  strip_tags($validated['code']),
            'name'         =>  strip_tags($validated['company_name']),
            'description'  =>  strip_tags($validated['description'])
        ]);

        $company_id = intval(base64_decode($request->input('company')));
        
        if (!empty($company_id))
        {
            $project->company()->associate($company_id);
        }

        $personIds = $request->input('person_ids', []);
        $project->persons()->sync($personIds);
        $project->save();

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-created');
    }

    public function showProject(Project $project): View
    {
        return parent::show($project);
    }

    public function editProject(Project $project): View
    {
        $viewData = clone $project;
        $viewData->companies = ArrayHelper::handle1($this->companyService->getAll(), ['id', 'name']);
        $viewData->selectedPersonIds = $project->persons->pluck('id')->toArray();
        return view(self::VIEW_NAME.'.'.'update', compact('viewData'));
    }

    public function updateProject(Request $request, Project $project): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'code'        => 'required|string|unique:projects|alpha_dash',
            'name'        => 'required|string',
            'description' => 'required|string',
            'company'     => 'required'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $project = Project::make([
            'code'        => strip_tags($validated['code']),
            'name'        => strip_tags($validated['name']),
            'description' => strip_tags($validated['description'])
        ], $project);
        
        $company_id = intval(base64_decode($request->input('company')));
        
        if (!empty($company_id))
        {
            $project->company()->associate($company_id);
        }

        $personIds = $request->input('person_ids', []);
        $project->persons()->sync($personIds);
        $project->save();

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-updated');
    }

    public function destroyProject(Project $project): RedirectResponse
    {
        $this->service->delete($project);
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'project-deleted');
    }

    public function getPersons(Project $project)
    {
        return response()->json($project->persons);
    }
}
