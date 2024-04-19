<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Models\Company;

class CompanyController extends CRUDController
{
    function __construct(CompanyService $service)
    {
        parent::__construct($service, 'companies');
    }
    
    public function showCompany(Company $company): View
    {
        return parent::show($company);
    }

    public function editCompany(Company $company): View
    {
        return parent::edit($company);
    }
}
