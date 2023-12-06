<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\DepartmentDataTable;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(DepartmentDataTable $dataTable)
    {
        return $dataTable->render('admin.auth.department.index');
    }
    public function store(Request $request)
    {
       // dd($request);
        $department = new Department();
       // dd( $department);
        $department->name = $request->input('name');
        $department->save();

        return response()->json(['message' => 'department added  successfully']);
    }

    public function destroy($id)
    {
        $department = Department::find($id);
        if ($department != null) {
            $department->delete();
            return response()->json(['message' => 'Department deleted successfully']);
        } else {
            return response()->json(['message' => 'Department not found'], 404);
        }
    }

    public function edit($id)
    {
        try {
            $department = Department::find($id);
            return response()->json($department);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {

        $department = Department::find($id);
        if (!$department) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
        $department->name = $request->input('name');
        $department->save();
        return response()->json(['success' => true, 'message' => 'Update successful']);
    }

    public function toggleStatus($id)
    {
        $department = Department::find($id);
        if ($department) {
            if($department->status=='0'){
                $department->status = '1';
                $department->save();
                return response()->json(['message' => 'Department status updated successfully.']);
            }else{
                $department->status = '0';
                $department->save();

                return response()->json(['message' => 'Department status updated successfully.']);
            }

        }
        return response()->json(['message' => 'Department not found.'], 404);
    }

    public function validatedepartmentname(Request $request)
    {
        $user = Department::where('name', $request->name)->first('name');
        if ($user) {
            $return =  false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit;
    }
}
