<?php 

namespace App\Repositories\Interfaces;

use App\Models\User;
use App\Models\Person;

interface PersonRepositoryInterface 
{
    public function createPerson(User $user, array $data): Person;
    public function updatePerson(Person $person, array $data): Person;
}