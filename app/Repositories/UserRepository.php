<?php 

namespace App\Repositories;

use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Models\Person;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    function __construct(User $model) 
    {
        parent::__construct($model);
    }

    public function createUser(array $data): User
    {
        $user = $this->model->create([
            'name'     => strip_tags($data['name']),
            'email'    => strip_tags($data['email']),
            'password' => strip_tags($data['password'])
        ]);

        $person = new Person;
        $user->person()->save($person);
        $user->roles()->attach($data['roles']);

        return $user;
    }

    public function updateUser(User $user, array $data): User
    {
        $user->update([
            'name'  => strip_tags($data['name']),
            'email' => strip_tags($data['email'])
        ]);

        $user->roles()->sync($data['roles']);

        return $user;
    }
}