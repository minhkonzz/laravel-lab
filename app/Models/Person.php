<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use App\Models\Company;
use App\Models\User;

class Person extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'gender',
        'birthdate',
        'phone_number',
        'address'
    ];

    public function company(): BelongsTo
    {
        $this->belongsTo(Company::class);
    }

    public function user(): BelongsTo
    {
        $this->belongsTo(User::class);
    }
}