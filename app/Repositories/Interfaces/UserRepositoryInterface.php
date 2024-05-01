<?php 

namespace App\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface 
{
    public function createUser(array $data): User;
    public function updateUser(User $user, array $data): User;
}