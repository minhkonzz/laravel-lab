<?php 

namespace App\Services\Interfaces;

use App\Models\Person;

interface PersonServiceInterface
{
    public function storePerson(array $requestData): Person;
    public function updatePerson(Person $person, array $requestData): Person; 
}