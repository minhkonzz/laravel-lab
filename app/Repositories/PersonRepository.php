<?php 

namespace App\Repositories;

use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Models\Person;
use App\Models\User;

class PersonRepository extends BaseRepository implements PersonRepositoryInterface
{
    function __construct(Person $model)
    {
        parent::__construct($model);
    }

    public function createPerson(User $user, array $data): Person
    {
        $person = $this->model->make([
            'full_name'     => strip_tags($data['full_name']),
            'gender'        => strip_tags($data['gender']),
            'birthdate'     => strip_tags($data['birthdate']),
            'phone_number'  => strip_tags($data['phone_number']),
            'address'       => strip_tags($data['address'])
        ]);

        if (isset($data['company_id']) && !empty($data['company_id']))
        {
            $person->company()->associate($company_id);
        }
        
        $savedPerson = $user->person()->save($person);
        $user->save();

        return $savedPerson;
    }

    public function updatePerson(Person $person, array $data): Person
    {
        $person->update([
            'full_name'    => strip_tags($data['full_name']),
            'gender'       => strip_tags($data['gender']),
            'birthdate'    => strip_tags($data['birthdate']),
            'phone_number' => strip_tags($data['phone_number']),
            'address'      => strip_tags($data['address'])           
        ]);     

        if (isset($data['company_id']) && !empty($data['company_id']))
        {
            $person->company()->associate($company_id);
        }
        
        $person->save();

        return $person;
    }
}