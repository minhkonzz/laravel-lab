<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;

class Department extends Model
{
    use HasFactory;

    public function company()
    {
        return $this->belongsTo(Company::class);
    }    

    public function children()
    {
        return $this->hasMany(Department::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Department::class, 'parent_id');
    }
}
