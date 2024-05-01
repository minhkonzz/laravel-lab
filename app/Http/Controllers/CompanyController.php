<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Helpers\ArrayHelper;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Services\Interfaces\DepartmentServiceInterface;
use App\Models\Company;
use App\Models\Department;

class CompanyController extends Controller
{
    const VIEW_NAME = 'companies';

    function __construct(
        CompanyServiceInterface    $service, 
        DepartmentServiceInterface $departmentService
    )
    {
        $this->service = $service;
        $this->departmentService = $departmentService;
    }

    public function index(): View
    {
        $companies = $this->service->getAllPaginated();
        return view(self::VIEW_NAME.'.'.'index', compact('companies'));
    }

    public function create(): View
    {
        return view(self::VIEW_NAME.'.'.'create');
    }
    
    /**
     * Show specific company information page
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
     */
    public function show(Company $company): View
    {
        return view(self::VIEW_NAME.'.'.'show', compact('company'));
    }

    /**
     * Store new company.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        try 
        {
            $company = $this->service->storeCompany($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'created-company');
        } 
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Show updating specific company information page
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
     */
    public function edit(Company $company): View
    {
        try
        {
            $viewData = $this->service->edit($company);
            return view(self::VIEW_NAME.'.'.'update', compact('viewData'));   
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage());
        }
    }

    /**
     * Update the specified company.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Company  $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Company $company): RedirectResponse
    {
        try 
        {
            $company = $this->service->updateCompany($company, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'updated-company');
        } 
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove specific company.
     *
     * @param  \App\Models\Company $company
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Company $company): RedirectResponse
    {
        try
        {
            $deleted = $this->service->delete($company);
            return back()->with('success', 'deleted-company');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
        
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
        $allChildren = $department->allChildren()->toArray();
        $viewData->departments = ArrayHelper::handle1($company_departments->reject(
            function ($item) use ($department, $allChildren) 
            {
                return $item->id === $department->id || in_array($item->id, array_column($allChildren, 'id'));
            }
        ));
        return view(self::VIEW_NAME.'.'.'departments'.'.'.'update', compact('viewData'));
    }

    /**
     * Store department of company
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Company $company
     * @return \Illuminate\View\View
    */
    public function storeDepartment(Request $request, Company $company): View
    {
        try 
        {
            $department = $this->departmentService->storeDepartment($company, $request->all());
            return $this->edit($company);
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Update specific department of company
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Department $department
     * @return \Illuminate\View\View
    */
    public function updateDepartment(Request $request, Department $department): View
    {
        try 
        {
            $department = $this->departmentService->updateDepartment($department, $request->all());
            return $this->edit($department->company);
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    /**
     * Remove specific department of company
     * @param  \App\Models\Department $department
     * @return \Illuminate\Http\RedirectResponse
    */
    public function destroyDepartment(Department $department): RedirectResponse
    {
        try
        {
            $deleted = $this->departmentService->delete($department);
            return back()->with('success', 'deleted-department');
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage());
        }
    }

    public function getPersons(Company $company)
    {
        return response()->json($company->persons);
    }
}
