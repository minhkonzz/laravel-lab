<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Models\Company;

class CompanyController extends CRUDController
{
    const VIEW_NAME = 'companies';

    function __construct(CompanyService $service)
    {
        parent::__construct($service, self::VIEW_NAME);
    }
    
    public function showCompany(Company $company): View
    {
        return parent::show($company);
    }

    public function editCompany(Company $company): View
    {
        return parent::edit($company);
    }

    public function getPersons(Company $company)
    {
        $persons = [
            ['id' => 'p1', 'full_name' => 'Anh Pham', 'birthdate' => '29-01-2001', 'phone_number' => '0967105498'],
            ['id' => 'p2', 'full_name' => 'Tuan Trung', 'birthdate' => '13-02-2001', 'phone_number' => '0966102485']
        ];

        return response()->json($company->person);
    }
}
