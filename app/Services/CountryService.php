<?php 

namespace App\Services;

use App\Repositories\CountryRepository;

class CountryService extends BaseService
{
    function __construct(CountryRepository $repository)
    {
        $this->repository = $repository;
    }
}