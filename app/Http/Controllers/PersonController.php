<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Services\PersonService;
use App\Services\UserService;
use App\Services\CompanyService;
use App\Http\Requests\Person\StorePersonRequest;
use App\Models\Person;
use App\Models\User;

class PersonController extends CRUDController
{
    const VIEW_NAME = 'persons';

    function __construct(PersonService $personService, UserService $userService, CompanyService $companyService)
    {
        parent::__construct($personService, self::VIEW_NAME);
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function create(): View
    {
        $companies = $this->companyService->getAll();
        return view(self::VIEW_NAME, compact('companies'));
    }

    public function storePerson(StorePersonRequest $request): RedirectResponse
    {
        $user = $this->userService->create([]);
        $person = Person::make($request->only([
            'full_name',
            'gender',
            'birthdate',
            'phone_number',
            'address',
        ]));

        // $person->company_id = intval(base64_decode($request->input('company')));
        $person->company_id = intval($request->input('company'));
        $user->person()->save($person);
        $user->save();
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'person-created');
    }

    public function showPerson(Person $person): View
    {
        return parent::show($person);
    }

    public function editPerson(Person $person): View
    {
        return parent::edit($person);
    }

    public function updatePerson(StorePersonRequest $request, int $id) 
    {
        $this->service->update($request->only([
            'full_name',
            'gender',
            'birthdate',
            'phone_number',
            'address',
        ]), $id);

        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'person-updated');
    }
}
