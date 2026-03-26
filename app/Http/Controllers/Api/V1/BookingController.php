<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Slot;
use Illuminate\Http\Request;
use App\Http\Resources\Api\V1\BookingResource;
use App\Http\Requests\Api\V1\Booking\StoreRequest;
use App\Events\BookingCreated;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $bookings = Booking::where('user_id', $request->user()->id)
            ->with(['slot.doctor', 'slot.service', 'user'])
            ->get();
        return BookingResource::collection($bookings);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $slot = Slot::findOrFail($request->slot_id);

        if ($slot->is_available)
        {
            $booking = Booking::create([
                "user_id" => $request->user()->id,
                "slot_id" => $slot->id,
                "status"  => "confirmed",
                "notes" => $request->notes
            ]);

            $booking->load(['slot.doctor', 'slot.service', 'user']);                
            BookingCreated::dispatch($booking);            

            // Mark the slot as unavailable
            $slot->update(['is_available' => false]);

            return response()->json(new BookingResource($booking), 201);
        } else {
            return response()->json(['message' => 'Slot is not available'], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        return new BookingResource($booking);
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Booking $booking, StoreRequest $request)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        $booking->slot->update(['is_available' => true]);
        $booking->delete();
        return response()->noContent();
    }
}
