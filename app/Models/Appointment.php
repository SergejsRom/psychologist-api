<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'time_slot_id',
        'client_name',
        'client_email',
    ];

    public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class);
    }
}
