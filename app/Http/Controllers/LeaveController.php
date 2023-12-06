<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Leave;
use App\DataTables\UserLeaveDataTable;
use App\Http\Requests\UserLeaveRequest;
use PhpParser\Node\Expr\FuncCall;

class LeaveController extends Controller
{


    public function indexx(UserLeaveDataTable $dataTable)
    {
        return $dataTable->render('leave');
    }


    public function submitLeaveRequest(Request $request)
    {
       // Leave::create($request->all());
        //$request->validate();
        $user_id = Auth::user()->id;
        $leave = new Leave();
        $leave->user_id = $user_id;
        $leave->startdatetime = $request->input('startdatetime');
        $leave->enddatetime = $request->input('enddatetime');
        $leave->leave_reason = $request->input('leave_reason');
        $leave->leave_status = $request->input('leave_status');
        $leave->save();

       // Leave::create($request->validated());
        return response()->json(['success' => true]);
    }

    public function view($id)
    {
        try {
            $record = Leave::with('user')->find($id);
            if ($record) {
                return response()->json($record);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        try {
            $leave = Leave::find($id);
            return response()->json($leave);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function update(UserLeaveRequest $request, $id)
    {
        // dd($request);
        $leave = Leave::find($id);

        if (!$leave) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }

        $leave->startdatetime = $request->input('startdatetime');
        $leave->enddatetime = $request->input('enddatetime');
        $leave->leave_reason = $request->input('leave_reason');
        $leave->leave_status = $request->input('leave_status');

        $leave->save();
        return response()->json(['success' => true, 'message' => 'Update successful']);
    }


}
