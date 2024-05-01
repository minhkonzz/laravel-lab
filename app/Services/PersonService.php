<?php 

namespace App\Services;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\PersonRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\Interfaces\PersonServiceInterface;
use App\Models\Person;

class PersonService extends BaseService implements PersonServiceInterface
{
    function __construct(UserRepositoryInterface $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function storePerson(array $requestData): Person
    {
        $validator = Validator::make($requestData, [
            'full_name'    => 'required|max:255|string',
            'gender'       => 'required|string',
            'birthdate'    => 'required|date',
            'phone_number' => 'required|string',
            'address'      => 'required|string'
        ]);

        if ($validator->fails())
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $user = $this->userRepository->create(['name' => $validated['full_name']]);
        $company_id = intval(base64_decode($requestData['company']));
        
        if ($company_id)
        {
            $validated['company_id'] = $company_id;
        }
        
        return $this->repository->createPerson($user, $validated);
    }

    public function updatePerson(Person $person, array $requestData): Person
    {
        $validator = Validator::make($requestData, [
            'full_name'    => 'required|max:255|string',
            'gender'       => 'required|string',
            'birthdate'    => 'required|date',
            'phone_number' => 'required|string',
            'address'      => 'required|string',
        ]);

        if ($validator->fails()) 
        {
            throw new ValidationException($validator);
        }

        $validated = $validator->validated();
        $company_id = intval(base64_decode($requestData['company']));
        
        if ($company_id)
        {
            $validated['company_id'] = $company_id;
        }

        return $this->repository->updatePerson($person, $validated);
    }

    protected function getRepositoryClass(): string
    {
        return PersonRepositoryInterface::class;
    }
}