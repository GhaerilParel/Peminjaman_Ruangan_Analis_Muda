<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    public function getRecommendedRooms(Request $request)
    {
        $capacity = $request->query('capacity');

        if (!$capacity || !is_numeric($capacity)) {
            return response()->json(['error' => 'Invalid capacity'], 400);
        }

        $rooms = Room::where('capacity', '>=', $capacity)->get();

        return response()->json($rooms);
    }
}