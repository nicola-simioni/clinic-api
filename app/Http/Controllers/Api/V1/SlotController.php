<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Slot\StoreRequest;
use App\Http\Resources\Api\V1\SlotResource;
use App\Models\Slot;
use Illuminate\Http\Request;

class SlotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $availableSlots = Slot::where('is_available', true)->with(['doctor','service'])->get();
        return SlotResource::collection($availableSlots);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $slot = Slot::create([
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
        ]);

        $slot->load(['doctor', 'service']);
        return response()->json(new SlotResource($slot), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Slot $slot)
    {
        return new SlotResource($slot);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRequest $request, Slot $slot)
    {
        $slot->update([
            'doctor_id' => $request->doctor_id,
            'service_id' => $request->service_id,
            'starts_at' => $request->starts_at,
            'ends_at' => $request->ends_at,
        ]);

        return new SlotResource($slot);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Slot $slot)
    {
        $slot->delete();
        return response()->noContent();
    }
}
