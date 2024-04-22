<?php 

namespace App\Services;

use App\Repositories\PersonRepository;

class PersonService extends BaseService
{
    function __construct(PersonRepository $repository)
    {
        parent::__construct($repository);
    }
}