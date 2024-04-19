<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Services\CountryService;
use App\Http\Requests\Country\StoreCountryRequest;
use App\Models\Country;

class CountryController extends CRUDController
{
    const VIEW_NAME = 'countries';

    function __construct(CountryService $service)
    {
        parent::__construct($service, self::VIEW_NAME);
    }

    public function storeCountry(StoreCountryRequest $request): RedirectResponse
    {
        return parent::store($request);
    }

    public function showCountry(Country $country): View
    {
        return parent::show($country);
    }

    public function editCountry(Country $country): View
    {
        return parent::edit($country);
    }

    public function updateCountry(StoreCountryRequest $request, int $id): RedirectResponse
    {
        return parent::update($request, $id);
    }
}
