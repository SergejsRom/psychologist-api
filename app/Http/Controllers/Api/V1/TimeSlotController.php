<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\V1\StoreTimeSlotRequest;
use App\Http\Requests\Api\V1\UpdateTimeSlotRequest;
use App\Models\TimeSlot;
use Illuminate\Http\Response;

class TimeSlotController extends Controller
{
    public function index($psychologistId)
    {
        $timeSlots = TimeSlot::where('psychologist_id', $psychologistId)
            ->where('is_booked', false)
            ->get();

        return response()->json($timeSlots, Response::HTTP_OK);
    }

    public function store(StoreTimeSlotRequest $request, $psychologistId)
    {
        $data = $request->validated();

        $overlap = TimeSlot::where('psychologist_id', $psychologistId)
            ->where('start_time', '<', $data['end_time'])
            ->where('end_time', '>', $data['start_time'])
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'Time slot overlaps with an existing slot.'
            ], Response::HTTP_BAD_REQUEST);
        }

        $timeSlot = TimeSlot::create([
            'psychologist_id' => $psychologistId,
            'start_time'      => $data['start_time'],
            'end_time'        => $data['end_time'],
        ]);

        return response()->json($timeSlot, Response::HTTP_CREATED);
    }

    public function update(UpdateTimeSlotRequest $request, $id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        $data = $request->validated();

        if (isset($data['start_time']) || isset($data['end_time'])) {
            $newStartTime = $data['start_time'] ?? $timeSlot->start_time;
            $newEndTime   = $data['end_time'] ?? $timeSlot->end_time;

            $overlap = TimeSlot::where('psychologist_id', $timeSlot->psychologist_id)
                ->where('id', '!=', $timeSlot->id)
                ->where('start_time', '<', $newEndTime)
                ->where('end_time', '>', $newStartTime)
                ->exists();

            if ($overlap) {
                return response()->json([
                    'message' => 'Time slot overlaps with an existing slot.'
                ], 400);
            }
        }

        $timeSlot->update($data);

        return response()->json($timeSlot, 200);
    }


    public function destroy($id)
    {
        $timeSlot = TimeSlot::findOrFail($id);
        $timeSlot->delete();

        return response()->json([
            'message' => 'Time slot deleted successfully.'
        ], Response::HTTP_OK);
    }
}
