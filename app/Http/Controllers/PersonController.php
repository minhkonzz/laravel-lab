<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\PersonService;
use App\Services\UserService;
use App\Http\Requests\Person\StorePersonRequest;
use App\Models\Person;
use App\Models\User;

class PersonController extends CRUDController
{
    function __construct(PersonService $personService, UserService $userService)
    {
        parent::__construct($personService, 'persons');
        $this->userService = $userService;
    }

    public function storePerson(StorePersonRequest $request): RedirectResponse
    {
        $user = $this->userService->create([]);

        $person = $this->service->create(['user_id' => $user->id] + $request->only([
            'full_name',
            'gender',
            'birthdate',
            'phone_number',
            'address',
        ]));

        $person->user()->associate($user);
        $person->save();
        return redirect()->route('person.index')->with('success', 'Person created');
    }

    public function showPerson(Person $person): View
    {
        return parent::show($person);
    }

    public function editPerson(Person $person): View
    {
        return parent::edit($person);
    }

    public function updatePerson(StorePersonRequest $request, string $id) 
    {
        $this->service->update($request->only([
            'full_name',
            'gender',
            'birthdate',
            'phone_number',
            'address',
        ]), $id);

        return redirect()->route('person.index')->with('success', 'Person updated');
    }
}
