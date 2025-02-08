<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens; 


class TimeSlot extends Model
{
    use HasApiTokens;

    protected $fillable = [
        'psychologist_id',
        'start_time',
        'end_time',
        'is_booked',
    ];

    public function psychologist()
    {
        return $this->belongsTo(Psychologist::class);
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
