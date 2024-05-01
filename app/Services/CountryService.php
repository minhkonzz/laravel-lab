<?php 

namespace App\Services;

use App\Services\Interfaces\CountryServiceInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryService extends BaseService implements CountryServiceInterface
{
    function __construct()
    {
        parent::__construct();
    }

    protected function getRepositoryClass(): string
    {
        return CountryRepositoryInterface::class;
    }
}