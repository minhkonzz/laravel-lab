<?php 

namespace App\Services;

use App\Repositories\UserRepository;

class UserService extends BaseService
{
    function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }
}