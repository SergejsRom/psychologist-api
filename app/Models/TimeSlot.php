<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
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
