<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\PersonService;
use App\Services\CompanyService;
use App\Services\UserService;
use App\Http\Requests\Person\StorePersonRequest;
use App\Helpers\ArrayHelper;
use App\Models\Person;
use App\Models\User;

class PersonController extends CRUDController
{
    const VIEW_NAME = 'persons';

    function __construct(
        PersonService $service, 
        UserService $userService,
        CompanyService $companyService
    )
    {
        parent::__construct($service, self::VIEW_NAME);
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function index(): View
    {
        $persons = Person::paginate(2);
        return view(self::VIEW_NAME.'.'.'index', compact('persons'));
    }

    public function create(): View
    {
        $companies = ArrayHelper::handle1($this->companyService->getAll());
        return view(self::VIEW_NAME.'.'.'create', compact('companies'));
    }

    /**
     * Store new person
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
    */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name'    => 'required|max:255|string',
            'gender'       => 'required|string',
            'birthdate'    => 'required|date',
            'phone_number' => 'required|string',
            'address'      => 'required|string'
        ]);

        if ($validator->fails())
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $person = Person::make([
            'full_name'     => strip_tags($validated['full_name']),
            'gender'        => strip_tags($validated['gender']),
            'birthdate'     => strip_tags($validated['birthdate']),
            'phone_number'  => strip_tags($validated['phone_number']),
            'address'       => strip_tags($validated['address'])
        ]);

        $user = $this->userService->create([
            'name' => $person->full_name
        ]);

        $company_id = intval(base64_decode($request->input('company')));
        $person->company()->associate($company_id);
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
        $viewData = clone $person;
        $viewData->companies = ArrayHelper::handle1($this->companyService->getAll());
        return parent::edit($viewData);
    }

    public function updatePerson(Request $request, Person $person): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'full_name'    => 'required|max:255|string',
            'gender'       => 'required|string',
            'birthdate'    => 'required|date',
            'phone_number' => 'required|string',
            'address'      => 'required|string',
        ]);

        if ($validator->fails()) 
        {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();
        
        $person = $this->service->update([
            'full_name'    => strip_tags($validated['full_name']),
            'gender'       => strip_tags($validated['gender']),
            'birthdate'    => strip_tags($validated['birthdate']),
            'phone_number' => strip_tags($validated['phone_number']),
            'address'      => strip_tags($validated['address'])
        ], $person);

        $company_id = intval(base64_decode($request->input('company')));
        $person->company()->associate($company_id);
        $person->save();
        
        return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'person-updated');
    }

    public function destroyPerson(Person $person): RedirectResponse
    {
        $this->userService->delete($person->user);
        return back()->with('success', 'deleted-person');
    }
}
