<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UserDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Department;
use App\Http\Requests\EmployeeRequest;
use App\Notifications\AdminNotification;

class EmployeeController extends Controller
{
    //
    public function index(UserDataTable $dataTable)
    {
        $departments = Department::all();
        return $dataTable->render('admin.auth.employee.employee_index', compact('departments'));
    }

    public function store(EmployeeRequest $request)
    {
        $emp = new User();
        $emp->name = $request->input('name');
        $emp->department_id = $request->input('department_id');
        $emp->email = $request->input('email');
        $emp->password = $request->input('password');
        $emp->mobile_no = $request->input('mobile_no');
        $emp->address = $request->input('address');
       // $emp->status = $request->input('status');
        $emp->save();

        return response()->json(['message' => 'employee added  successfully']);
    }

    public function destroy($id)
    {
        $emp = User::find($id);
        if ($emp != null) {
            $emp->delete();
            return response()->json(['message' => 'Employee deleted successfully']);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }

    public function toggleStatus($id)
    {
        $emp = User::find($id);
        if ($emp) {
            if ($emp->status == '0') {
                $emp->status = '1';
                $emp->save();
                return response()->json(['message' => 'Employee status updated successfully.']);
            } else {
                $emp->status = '0';
                $emp->save();
                return response()->json(['message' => 'Employee status updated successfully.']);
            }
        }
        return response()->json(['message' => 'Department not found.'], 404);
    }

    public function edit($id)
    {
        try {
            $emp = User::find($id);
            return response()->json($emp);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $emp = User::find($id);
        if (!$emp) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
        $emp->department_id = $request->input('department_id');
        $emp->mobile_no = $request->input('mobile_no');
        $emp->address = $request->input('address');
        $emp->save();
        return response()->json(['success' => true, 'message' => 'Update successful']);
    }
    public function validateuseremail(Request $request)
    {
        $user = User::where('email', $request->email)->first('email');
        if ($user) {
            $return =  false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit;
    }
    public function validateusermobile(Request $request)
    {
        $user = User::where('mobile_no', $request->mobile_no)->first('mobile_no');
        if ($user) {
            $return =  false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit;
    }

}
