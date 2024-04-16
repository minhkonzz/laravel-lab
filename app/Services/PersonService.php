<?php 

namespace App\Services;

use App\Repositories\PersonRepository;

class PersonService extends BaseService
{
    public function __construct(PersonRepository $repository)
    {
        $this->repository = $repository;
    }
}