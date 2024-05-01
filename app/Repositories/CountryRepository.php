<?php 

namespace App\Repositories;

use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Models\Country;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    function __construct(Country $model)
    {
        parent::__construct($model);
    }
}