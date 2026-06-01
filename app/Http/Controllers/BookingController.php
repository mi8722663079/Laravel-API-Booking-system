<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookingResource;
use App\Models\Booking;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function book(Request $request)
    {
        $request->validate([
            "event_id" => "required|integer|exists:events,id",
            "status" => "required|in:pending,confirmed,cancelled"
        ]);
        $event = Event::find($request->event_id);
        if (!$event) {
            return response()->json([
                "success" => false,
                "message" => "Event not found"
            ],404);
        }
        $user = Auth::user();
        $booking = Booking::where("user_id",$user->id)->where("event_id",$event->id)->exists();
        if ($booking) {
            return response()->json([
                "success" => false,
                "message" => "You have already booked this event!"
            ],400);
        }
        if($event->avaliable_seats <= 0){
            return response()->json([
                "success" => false,
                "message" => "No seats available for this event!"
            ],400);
        }
        $booking = Booking::create([
            'user_id' => $user->id,
            'event_id' => $event->id,
            'status' => $request->status?? "pending",
        ]);

        $event->decrement('avaliable_seats');

        return response()->json([
            "success" => true,
            "message" => "Booking created successfully",
            "data" => new BookingResource($booking)
        ],201);
    }

    public function allBookings(){
        $bookings = Booking::with(["event","user"])->get();
        return response()->json([
            "success" => true,
            "message" => "Bookings retrieved successfully",
            "data" => BookingResource::collection($bookings)
        ],200);
    }

    public function userBookings(){
        $user = Auth::user();
        $bookings = Booking::with(["event","user"])->where("user_id",$user->id)->get();
        return response()->json([
            "success" => true,
            "message" => "Your bookings retrieved successfully",
            "data" => BookingResource::collection($bookings)
        ],200);
    }
    public function allConfirmedBookings(){
        $bookings = Booking::with(["event","user"])->confirmed()->get();
        return response()->json([
            "success" => true,
            "message" => "Confirmed bookings retrieved successfully",
            "data" => BookingResource::collection($bookings)
        ],200);
    }

    public function update(Request $request){
        $user = Auth::user();
        if($user->role !== "admin"){
            return response()->json([
                "success" => false,
                "message" => "Unauthorized"
            ],403);
        }
        $request->validate([
            "event_id" => "required|integer|exists:events,id",
            "status" => "required|in:pending,confirmed,cancelled"
            ]);

        $booking = Booking::where("user_id",$user->id)->where("event_id",$request->event_id)->first();
        if (!$booking) {
            return response()->json([
                "success" => false,
                "message" => "Booking not found"
            ],404);
        }

        $booking->update([
            "status" => $request->status
        ]);

        return response()->json([
            "success" => true,
            "message" => "Booking updated successfully",
            "data" => new BookingResource($booking)
        ],200);
    }

    public function destroy($id){
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                "success" => false,
                "message" => "Booking not found"
            ],404);
        }
        $booking->event()->increment('avaliable_seats');
        $booking->delete();
        return response()->json([
            "success" => true,
            "message" => "Booking deleted successfully"
        ],200);
    }
}
