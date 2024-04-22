<?php 

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService extends BaseService
{
    function __construct(CompanyRepository $repository)
    {
        parent::__construct($repository);
    }
}