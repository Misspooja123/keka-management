<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AdminUserDataTable;
use App\Models\Admin;
use Spatie\Permission\Models\Role;
use App\Http\Requests\AdminUserStoreRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminUserController extends Controller
{
    //
    public function index(AdminUserDataTable $dataTable)
    {
        $admins = Role::all();
        return $dataTable->render('admin.auth.adminuser.index', compact('admins'));
    }

    public function store(AdminUserStoreRequest $request)
    {
        $admin = new Admin();
        $admin->name = $request->input('name');
        $admin->email = $request->input('email');
        $admin->password = Hash::make($request->input('password'));
        $admin->role_id = $request->input('role_id');
        $role = Role::find($admin->role_id);
        if ($role) {
            $roleName = $role->name;
            $admin->assignRole($roleName);
        } else {
            return response()->json(['error' => 'Role does not exist.'], 404);
        }
        $admin->save();
        return response()->json(['message' => 'Admin user added  successfully']);
    }

    public function edit($id)
    {
        try {
            $admin = Admin::find($id);
            return response()->json($admin);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::find($id);
        if (!$admin) {
            return response()->json(['success' => false, 'message' => 'Record not found']);
        }
        $admin->role_id = $request->input('role_id');
        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $role = Role::find($admin->role_id);
        if ($role) {
            $roleName = $role->name;
            $admin->assignRole($roleName);
        } else {
            return response()->json(['error' => 'Role does not exist.'], 404);
        }

        $admin->save();
        return response()->json(['success' => true, 'message' => 'Update successful']);
    }


    public function validateuseremail(Request $request)
    {
        $user = Admin::where('email', $request->email)->first('email');
        // dd($user);
        if ($user) {
            $return =  false;
        } else {
            $return = true;
        }
        echo json_encode($return);
        exit;
    }
}
