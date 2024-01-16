<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\RoleDataTable;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    //
    public function index(RoleDataTable $dataTable, Request $request)
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

    public function storeRole(Request $request)
    {
        dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
        ]);
        $role = Role::create([
            'name' => $request->input('name'),
            'guard_name' => 'admin'
        ]);
        $permission = $role->syncPermissions($request->input('module_permissions'));

        return redirect()->back()->with('success', 'Role created successfully!');
    }

    public function edit($id)
    {
        try {
            $roles = Role::find($id);
            $permission = DB::table('role_has_permissions')
                ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
                ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
                ->where('role_has_permissions.role_id', $id)->get('permissions.name');
            return response()->json([
                'id' => $roles['id'],
                'name' => $roles['name'],
                'permission' => $permission

            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $role = Role::find($id);
            if (!$role) {
                return response()->json(['success' => false, 'message' => 'Role not found'], 404);
            }
            $role->update([
                'name' => $request->input('name'),
                'guard_name' => 'admin'
            ]);
            // Sync the permissions
            $role->syncPermissions($request->input('module_permissions'));

            return response()->json(['success' => true, 'message' => 'Role updated successfully']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }


    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role != null) {
            $role->delete();
            return response()->json(['message' => 'Role deleted successfully']);
        } else {
            return response()->json(['message' => 'Role not found'], 404);
        }
    }

}
