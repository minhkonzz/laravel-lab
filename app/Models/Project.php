<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Task;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 
        'name',
        'description'
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function persons(): BelongsToMany
    {
        return $this->belongsToMany(Person::class);
    }

    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
