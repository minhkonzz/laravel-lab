<?php 

namespace App\Services;

use App\Repositories\PersonRepository;

class PersonService extends BaseService
{
    function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }
}