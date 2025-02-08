<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 

class Psychologist extends Authenticatable
{
    use HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    protected function casts(): array
{
    return [
        'password' => 'hashed',
    ];
}
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}
