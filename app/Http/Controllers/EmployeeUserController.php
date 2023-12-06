<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class EmployeeUserController extends Controller
{
    //
    public function index(Request $request)
    {
        $selectedDepartments = $request->input('selected_departments', []);
        $loggedInUserDepartmentId = Auth::user()->department_id;
        if (empty($selectedDepartments)) {
            $selectedDepartments = [$loggedInUserDepartmentId];
        }

        $departments = Department::all();
        $userDepartment = Auth::user()->department->name;
        $userDepartmentId = Auth::user()->department_id;

        return view('employee', compact(
            'departments',
            'loggedInUserDepartmentId',
            'selectedDepartments',
            'userDepartment',
            'userDepartmentId'
        ));
    }

    public function getEmployees(Request $request)
    {
        $selectedDepartmentIds = $request->input('selected_departments', []);
        $employees = User::whereIn('department_id', $selectedDepartmentIds)->with('department')->get();
        $employees->load('department');
        return response()->json(['employees' => $employees]);
    }

    public function searchEmployees(Request $request)
    {
        $departmentName = $request->input('departmentName');
        $selectedDepartments = $request->input('selected_departments', []);

        $query = User::query();

        if (!empty($selectedDepartments)) {
            $query->whereIn('department_id', $selectedDepartments);
        }

        // $employees = User::whereHas('user', function ($query) use ($departmentName) {
        //     $query->where('name', 'LIKE', '%' . $departmentName . '%');
        // })->whereIn('department_id', $selectedDepartments)->with('department')->get();

        if (!empty($departmentIds)) {
            $query->whereIn('department_id', $departmentIds);
        }

        $employees = User::where('name', 'LIKE', '%' . $departmentName . '%')->whereIn('department_id', $selectedDepartments)->with('department')->get();
        $employees = User::where('email', 'LIKE', '%' . $departmentName . '%')->whereIn('department_id', $selectedDepartments)->with('department')->get();

        return response()->json(['employees' => $employees]);
    }
}
