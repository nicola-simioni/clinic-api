<?php
namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Http\Resources\Api\V2\BookingResource;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = Booking::where('user_id', $request->user()->id)->get();
        return BookingResource::collection($bookings);
    }
}