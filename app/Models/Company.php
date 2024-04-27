<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Project;
use App\Models\Department;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address'
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function persons(): HasMany
    {
        return $this->hasMany(Person::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
}
