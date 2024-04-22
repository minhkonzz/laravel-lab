<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;
use App\Models\Task;

class Project extends Model
{
    use HasFactory;

    public function person(): BelongsToMany
    {
        return $this->belongsTo(Person::class);
    }

    public function task(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
