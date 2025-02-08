<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreAppointmentRequest;
use App\Models\TimeSlot;
use App\Models\Appointment;
use Illuminate\Http\Response;

class AppointmentController extends Controller
{
    public function store(StoreAppointmentRequest $request)
    {
        $data = $request->validated();

        $timeSlot = TimeSlot::findOrFail($data['time_slot_id']);

        if ($timeSlot->is_booked) {
            return response()->json([
                'message' => 'This time slot is already booked.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $timeSlot->update(['is_booked' => true]);

        $appointment = Appointment::create($data);

        return response()->json($appointment, Response::HTTP_CREATED);
    }


    public function index()
    {
        $appointments = Appointment::with('timeSlot')->get();

        return response()->json($appointments, Response::HTTP_OK);
    }
    
}
