<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function getRecommendations(Request $request)
    {
        $capacity = $request->query('capacity', 0);

        // Query rooms with capacity greater than or equal to the requested capacity
        $rooms = Room::where('capacity', '>=', $capacity)->get();

        return response()->json($rooms);
    }
}