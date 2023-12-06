<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\LeaveDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Leave;

class LeaveStatusController extends Controller
{
    //
    public function index(LeaveDataTable $dataTable)
    {
        return $dataTable->render('admin.auth.leave_status');
    }
    public function approve(Request $request, $id)
    {
        $status = $request->input('status');
        try {
            $record = Leave::find($id);
            if ($record) {

                if ($status == 'approved') {
                    $record->status = '1';
                    $record->reject_reason = NULL;
                    $record->save();
                    return response()->json(['success' => true, 'message' => 'Leave has been approved.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function reject(Request $request, $id)
    {
        $status = $request->input('status');
        try {
            $record = Leave::find($id);
            if ($record) {

                if ($status == 'rejected') {
                    $record->status = '2';
                    $record->reject_reason = request('reject_reason');
                    $record->save();
                    return response()->json(['success' => true, 'message' => 'Leave has been Rejected.']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function view($id)
    {
        try {
            $record = Leave::with('user')->find($id);
           // $record = Leave::with('user:id,name')->get();
            // dd($record);
            if ($record) {
                return response()->json($record);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

}
