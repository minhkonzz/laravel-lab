<?php 

namespace App\Services;

use App\Repositories\Interfaces\CompanyRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Helpers\ArrayHelper;
use App\Models\Company;
use App\Models\Department;

class CompanyService extends BaseService implements CompanyServiceInterface
{
    function __construct()
    {
        parent::__construct();
    }

    public function edit(Company $company): Company
    {
        $viewData = clone $company;
        $rootCompanyDepartments = $company->departments->whereNull('parent_id');
        Department::buildDepartmentTree($rootCompanyDepartments, $company->departments);
        $viewData->departments = $rootCompanyDepartments;
        return $viewData;
    }

    public function storeCompany(array $requestData): Company
    {
        $validator = Validator::make($requestData, [
            'name'    => 'required|string|max:255',
            'code'    => 'required|string|max:255|unique:companies',
            'address' => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        
        $attributes = [
            'name'    => strip_tags($validated['name']),
            'code'    => strip_tags($validated['code']),
            'address' => strip_tags($validated['address']) 
        ];

        return parent::store($attributes);
    } 

    public function updateCompany(Company $company, array $requestData): Company
    {
        $validator = Validator::make($requestData, [
            'name'    => 'bail|required|string|max:255',
            'code'    => 'required|string|max:255|unique:companies',
            'address' => 'required|string'
        ]);

        if ($validator->fails()) 
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();

        $attributes = [
            'name'    => strip_tags($validated['name']),
            'code'    => strip_tags($validated['code']),
            'address' => strip_tags($validated['address']) 
        ];

        return parent::update($company, $attributes);
    }

    protected function getRepositoryClass(): string
    {
        return CompanyRepositoryInterface::class;
    }
}