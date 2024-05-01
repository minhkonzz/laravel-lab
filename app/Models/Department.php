<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Company;

class Department extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }   

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }
    
    public function children(): HasMany
    {
        return $this->hasMany(Department::class, 'parent_id');
    }

    public static function buildDepartmentTree($departments, $allDepartments)
    {
        foreach ($departments as $department) 
        {
            $department->children = $allDepartments->where('parent_id', $department->id)->values();
            if ($department->children->isEmpty()) break;
            self::buildDepartmentTree($department->children, $allDepartments);
        }
    }

    public function allChildren(): Collection
    {
        $allChildren = $this->children;

        foreach ($this->children as $child) 
        {
            $allChildren = $allChildren->merge($child->allChildren());
        }

        return $allChildren;
    }

    public function isChild(): bool
    {
        return $this->parent_id !== null;
    }
}
