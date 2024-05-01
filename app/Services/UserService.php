<?php 

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Models\User;

class UserService extends BaseService implements UserServiceInterface
{
    function __construct()
    {
        parent::__construct();
    }

    public function storeUser(array $requestData): User
    {
        $validator = Validator::make($requestData, [
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $validated['roles'] = array_filter(array_map(fn($item) => intval(base64_decode($item)), $requestData['roles']));   

        return $this->repository->createUser($validated);
    }

    public function updateUser(User $user, array $requestData): User
    {
        $validator = Validator::make($requestData, [
            'name'  => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users' 
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $validated['roles'] = array_filter(array_map(fn($item) => intval(base64_decode($item)), $requestData['roles']));   

        return $this->repository->updateUser($user, $validated);
    }

    protected function getRepositoryClass(): string
    {
        return UserRepositoryInterface::class;
    }
}