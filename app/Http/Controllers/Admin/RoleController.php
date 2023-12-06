<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    //
    public function index(RoleDataTable $dataTable)
    {
        $permissions = Permission::all();

        $dashboard_module = $permissions->where('module', 'dashboard')->pluck('module')->unique();
        $dashboard_name = $permissions->where('module', 'dashboard')->pluck('name');

        $attendance_module = $permissions->where('module', 'attendance')->pluck('module')->unique();
        $attendance_name = $permissions->where('module', 'attendance')->pluck('name');

        $leave_module = $permissions->where('module', 'leave')->pluck('module')->unique();
        $leave_name = $permissions->where('module', 'leave')->pluck('name');

        $department_module = $permissions->where('module', 'department')->pluck('module')->unique();
        $department_name = $permissions->where('module', 'department')->pluck('name');

        $employee_module = $permissions->where('module', 'employee')->pluck('module')->unique();
        $employee_name = $permissions->where('module', 'employee')->pluck('name');

        $marksheet_module = $permissions->where('module', 'marksheet')->pluck('module')->unique();
        $marksheet_name = $permissions->where('module', 'marksheet')->pluck('name');

        $role_module = $permissions->where('module', 'role')->pluck('module')->unique();
        $role_name = $permissions->where('module', 'role')->pluck('name');

        $adminuser_module = $permissions->where('module', 'adminuser')->pluck('module')->unique();
        $adminuser_name = $permissions->where('module', 'adminuser')->pluck('name');

        return $dataTable->render('admin.auth.role.index', compact('dashboard_module', 'dashboard_name', 'attendance_module', 'attendance_name', 'leave_module', 'leave_name', 'department_module', 'department_name', 'employee_module', 'employee_name', 'marksheet_module', 'marksheet_name', 'role_module', 'role_name', 'adminuser_module', 'adminuser_name'));

    }
}
