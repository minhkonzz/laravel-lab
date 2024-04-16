<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompanyService;

class CompanyController extends CRUDController
{
    function __construct(CompanyService $service)
    {
        $this->service = $service;
    }
}
