<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
use App\Services\CompanyService;
use App\Services\DepartmentService;
use App\Models\Company;
use App\Models\Department;

class CompanyController extends CRUDController
{
    const VIEW_NAME = 'companies';

    function __construct(CompanyService $service, DepartmentService $departmentService)
    {
        parent::__construct($service, self::VIEW_NAME);
        $this->departmentService = $departmentService;
    }

    public function index(): View
    {
        $companies = Company::paginate(2);
        return view(self::VIEW_NAME.'.'.'index', compact('companies'));
    }
    
    /**
     * Show specific company information page
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
     */
    public function showCompany(Company $company): View
    {
        return parent::show($company);
    }

    /**
     * Store new company.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'bail|required|max:255|unique:companies|alpha_dash',
            'code'    => 'required|max:255|unique:companies',
            'address' => 'required'
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $company = $this->service->create([
            'name'    => strip_tags($validated['name']),
            'code'    => strip_tags($validated['code']),
            'address' => strip_tags($validated['address']) 
        ]);

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'created-company');
    }

    /**
     * Show updating specific company information page
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
     */
    public function editCompany(Company $company): View
    {
        $viewData = clone $company;
        $rootCompanyDepartments = $company->departments->whereNull('parent_id');
        Department::buildDepartmentTree($rootCompanyDepartments, $company->departments);

        $viewData->departments = [
            'tree' => $rootCompanyDepartments,
            'short' => ArrayHelper::handle1($company->departments)
        ];
        return parent::edit($viewData);
    }

    /**
     * Update the specified company.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCompany(Request $request, Company $company): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'bail|required|max:255|unique:companies|alpha_dash',
            'code'    => 'required|max:255|unique:companies',
            'address' => 'required'
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $company = $this->service->update([
            'name'    => strip_tags($validated['name']),
            'code'    => strip_tags($validated['code']),
            'address' => strip_tags($validated['address']) 
        ], $company);

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'updated-company');
    }

    /**
     * Remove specific company.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroyCompany(Company $company): RedirectResponse
    {
        $this->service->delete($company);
        return back()->with('success', 'deleted-company');
    }

    /**
     * Show create department of company page
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
     */
    public function createDepartment(Company $company): View
    {
        $viewData = clone $company;
        $viewData->departments = ArrayHelper::handle1($company->departments);
        return view(self::VIEW_NAME.'.'.'departments'.'.'.'create', compact('viewData'));
    }

    /**
     * Show update department of company page
     *
     * @param  \App\Models\Department $department
     * @return \Illuminate\View\View
     */
    public function editDepartment(Department $department): View
    {
        $company_departments = $department->company->departments;
        $viewData = clone $department; 
        $viewData->departments = ArrayHelper::handle1($company_departments->reject(function ($item) use ($department) {
            return $item->id === $department->id;
        }));
        return view(self::VIEW_NAME.'.'.'departments'.'.'.'update', compact('viewData'));
    }

    /**
     * Store / Update specific department of company
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
    */
    public function storeOrUpdateDepartment(Request $request, Company $company): View
    {
        $validator = Validator::make($request->all(), [
            'name'              => 'required|max:255|unique:departments',
            'code'              => 'required|max:255|unique:departments',
            'parent_department' => 'integer'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        
        $department = Department::make([
            'code' => strip_tags($validated['code']),
            'name' => strip_tags($validated['name'])
        ]);      

        $parent_department_id = intval(base64_decode($validated['parent_department']));
        $department->company()->associate($company->id);

        if ($parent_department_id) 
        {
            $department->parent()->associate($parent_department_id);
        }
        
        $department->save();

        return $this->editCompany($company);
    }

    /**
     * Remove specific department of company
     * @param  \App\Models\Department $department
     * @return \Illuminate\Http\RedirectResponse
    */
    public function destroyDepartment(Department $department): RedirectResponse
    {
        $this->departmentService->delete($department);
        return back()->with('success', 'deleted-department');
    }

    public function getPersons(Company $company)
    {
        return response()->json($company->persons);
    }
}
