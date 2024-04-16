<?php 

namespace App\Services;

use App\Repositories\CompanyRepository;

class CompanyService extends BaseService
{
    public function __construct(CompanyRepository $repository)
    {
        $this->repository = $repository;
    }
}