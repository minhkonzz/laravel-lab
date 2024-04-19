<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Person;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'address'
    ];

    public function person() 
    {
        $this->hasMany(Person::class);
    }
}
