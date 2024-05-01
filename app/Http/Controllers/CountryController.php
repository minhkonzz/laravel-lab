<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\Interfaces\CountryServiceInterface;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Models\Country;

class CountryController extends Controller
{
    const VIEW_NAME = 'countries';

    function __construct(CountryServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(): View
    {
        $countries = $this->service->getAll();
        return view(self::VIEW_NAME.'.'.'index', compact('countries'));
    }

    public function create(): View
    {
        return view(self::VIEW_NAME.'.'.'create');
    }

    public function store(StoreCountryRequest $request): RedirectResponse
    {
        try
        {
            $country = $this->service->store($request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function show(Country $country): View
    {
        return view(self::VIEW_NAME.'.'.'show', compact('country'));
    }

    public function edit(Country $country): View
    {
        return view(self::VIEW_NAME.'.'.'update', compact('country'));
    }

    public function update(StoreCountryRequest $request, Country $country): RedirectResponse
    {
        try
        {
            $country = $this->service->update($country, $request->all());
            return redirect()->route(self::VIEW_NAME.'.'.'index');
        }
        catch (Exception $e)
        {
            return back()->withErrors($e->getMessage())->withInput();
        }
    }

    public function destroy(Country $country): RedirectResponse
    {
        try
        {
            $deleted = $this->service->delete($country);
            return redirect()->route(self::VIEW_NAME.'.'.'index');
        }
        catch (Exception $e) 
        {
            return back()->withErrors($e->getMessage());
        }
    }
}
