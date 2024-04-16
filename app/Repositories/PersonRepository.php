<?php 

namespace App\Repositories;

use App\Models\Person;

class PersonRepository extends BaseRepository
{
    public function __construct(Person $model)
    {
        parent::__construct($model);
    }
}