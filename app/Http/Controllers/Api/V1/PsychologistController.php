<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Http\Requests\Api\V1\StorePsychologistRequest;
use App\Models\Psychologist;


class PsychologistController extends Controller
{
    public function store(StorePsychologistRequest $request)
    {
        $data = $request->validated();

        $psychologist = Psychologist::create($data);

        return response()->json($psychologist, Response::HTTP_CREATED);
    }

    public function index()
    {
        $psychologists = Psychologist::all();
        return response()->json($psychologists, Response::HTTP_OK);
    }
}
