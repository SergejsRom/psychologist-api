<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\V1\PsychologistController;
use App\Http\Controllers\Api\V1\TimeSlotController;
use App\Http\Controllers\Api\V1\AppointmentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    
    Route::post('/psychologists', [PsychologistController::class, 'store']);
    Route::get('/psychologists', [PsychologistController::class, 'index']);

    Route::post('/psychologists/{id}/time-slots', [TimeSlotController::class, 'store']);
    Route::get('/psychologists/{id}/time-slots', [TimeSlotController::class, 'index']);
    Route::put('/time-slots/{id}', [TimeSlotController::class, 'update']);
    Route::delete('/time-slots/{id}', [TimeSlotController::class, 'destroy']);

    Route::post('/appointments', [AppointmentController::class, 'store']);
    Route::get('/appointments', [AppointmentController::class, 'index']);
});