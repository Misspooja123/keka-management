<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\AttendanceDataTable;
use Yajra\DataTables\Facades\Datatables;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.auth.dashboard');
    }
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'email' => "required|max:255 ",
                'password' => "required|min:6 ",
            ];

            $customMessages = [
                'email.required' => "Email is required",
                'password.required' => "Password is required",
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect("admin/dashboard");
            } else {
                return redirect()->back()->with("error_message", "Invalid email or password");
            }
        }
        return view('admin.auth.login');
    }
    public function indexx(Request $request)
    {

        if ($request->ajax()) {
            $data = Attendance::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.auth.attendance');
    }

    public function index(AttendanceDataTable $dataTable)
    {
        return $dataTable->render('admin.auth.index');
    }

    public function edit($id)
    {
        $data = Attendance::find($id);
        return view('admin.auth.attendance', compact('data'));
    }

    public function update(Request $request, $id)
    {
        try {
            $record = Attendance::find($id);
            if (!$record) {
                return response()->json(['success' => false, 'message' => 'Record not found']);
            }
            $record->starttime = $request->starttime;
            $record->endtime = $request->endtime;
            $record->save();
            return response()->json(['success' => true, 'message' => 'Update successful']);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
