<?php 

namespace App\Services\Interfaces;

use App\Models\User;

interface UserServiceInterface 
{
    public function storeUser(array $requestData): User;
    public function updateUser(User $user, array $requestData): User;
}