<?php 

namespace App\Repositories;

use App\Models\Person;

class PersonRepository extends BaseRepository
{
    function __construct(Person $model)
    {
        parent::__construct($model);
    }
}