<?php 

namespace App\Services\Interfaces;

use App\Models\Company;

interface CompanyServiceInterface
{
    public function edit(Company $company): Company;
    public function storeCompany(array $requestData): Company;
    public function updateCompany(Company $company, array $requestData): Company;
}