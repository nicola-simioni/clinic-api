<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Http\Resources\Api\V1\DoctorResource;
use App\Http\Requests\Api\V1\Doctor\StoreRequest;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $doctors = Doctor::where('is_active', true)->get();
        return DoctorResource::collection($doctors);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $doctor = Doctor::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'specialization' => $request->specialization
        ]);

        return response()->json(new DoctorResource($doctor), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Doctor $doctor)
    {
        return new DoctorResource($doctor);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Doctor $doctor)
    {
        $doctor->update([            
            'name' => $request->name,
            'specialization' => $request->specialization
        ]);

        return new DoctorResource($doctor);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Doctor $doctor)
    {
        $doctor->delete();
        return response()->noContent();
    }
}