<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Session\Session;


class AttendanceController extends Controller
{
    public function attendance(){
        return view('attendance');
    }

    public function clockInAjax(Request $request)
    {
        $starttime = Carbon::now('Asia/Kolkata');
        $user_id = auth()->user()->id;
        $user_name = auth()->user()->name;

        $attendance = Attendance::where('user_id', $user_id )->first();
        $request->validate([
            'description' => 'required',
        ]);

        if ($attendance != null) {
            $attendance->starttime = $starttime;
            $attendance->status = 1;

            $attendance->description = $request->input('description');
            $attendance->user_name = $user_name;
            $attendance->save();
            return response()->json(['success' => true]);
        } else {
            $attendance = new Attendance();
            $attendance->user_id = $user_id;
            $attendance->starttime = $starttime;
            $attendance->description = $request->input('description');
            $attendance->user_name = $user_name;
            $attendance->status = 1;
            $attendance->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['error' => true]);
    }

    public function clockOutAjax(Request $request)
    {

        $user_id = auth()->user()->id;
        $user_name = auth()->user()->name;
        $attendance = Attendance::where('user_id', $user_id)->first();

        if ($attendance != null) {
            // Update only the endtime
            $attendance->endtime = Carbon::now('Asia/Kolkata');
            $attendance->user_name = $user_name;
            $attendance->status = 0;
            $attendance->save();

            return response()->json(['success' => true]);
        } else {
            $attendance = new Attendance();
            $attendance->user_id = $user_id;
            $attendance->user_name = $user_name;
            $attendance->status = 0;
            $attendance->save();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => true]);
    }

}
