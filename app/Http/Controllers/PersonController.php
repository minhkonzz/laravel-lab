<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Services\Interfaces\PersonServiceInterface;
use App\Services\Interfaces\CompanyServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Http\Requests\Person\StorePersonRequest;
use App\Helpers\ArrayHelper;
use App\Models\Person;
use App\Models\User;

class PersonController extends Controller
{
    const VIEW_NAME = 'persons';

    function __construct(
        PersonServiceInterface  $service, 
        UserServiceInterface    $userService,
        CompanyServiceInterface $companyService
    )
    {
        $this->service = $service;
        $this->userService = $userService;
        $this->companyService = $companyService;
    }

    public function index(): View
    {
        $persons = $this->service->getAllPaginated();
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
        try
        {
            $person = $this->service->storePerson($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'person-created');
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(Person $person): View
    {
        return view(self::VIEW_NAME.'.'.'show', compact('person'));
    }

    public function edit(Person $person): View
    {
        $viewData = clone $person;
        $viewData->companies = ArrayHelper::handle1($this->companyService->getAll());
        return view(self::VIEW_NAME.'.'.'update', compact('viewData'));
    }

    public function update(Request $request, Person $person): RedirectResponse
    {
        try
        {
            $person = $this->service->updatePerson($person, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index')->with('success', 'person-updated');
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Person $person): RedirectResponse
    {
        try
        {
            $deleted = $this->userService->delete($person->user);
            return back()->with('success', 'deleted-person');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage());
        }
    }
}
