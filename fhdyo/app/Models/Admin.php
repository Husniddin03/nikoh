<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'username',
        'password',
        'is_super_admin',
    ];

    protected $casts = [
        'is_super_admin' => 'boolean',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
