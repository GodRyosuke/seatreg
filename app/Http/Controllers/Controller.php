<?php

namespace App\Http\Controllers;

use App\Building;
use App\Room;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function seat_id($department, $room_name)
    {
        $buildings = Building::where('department',$department)->first();
        $rooms = Room::where('name',$room_name)->first();

        return view('building',  ['bulidings' => $buildings, 'rooms' => $rooms]);
    }
}
