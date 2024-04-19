<?php

namespace App\Repositories;

use App\Models\Company;

class CompanyRepository extends BaseRepository
{
    function __construct(Company $model)
    {
        parent::__construct($model);
    }
}