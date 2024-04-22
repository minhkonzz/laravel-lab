<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Services\DepartmentService;
use App\Models\Department;

class DepartmentController extends CRUDController
{
    function __construct(DepartmentService $service)
    {
        parent::__construct($service);
    }
}
