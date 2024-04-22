<?php 

namespace App\Services;

use App\Repositories\CountryRepository;

class CountryService extends BaseService
{
    function __construct(CountryRepository $repository)
    {
        parent::__construct($repository);
    }
}