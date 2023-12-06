<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $modules = ['dashboard', 'attendance', 'leave', 'department', 'employee', 'marksheet', 'role' , 'adminuser'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                Permission::create([
                    'name' => $module . '_' . $action,
                    'guard_name' => 'admin',
                    'module' => $module,
                ]);
            }
        }
    }


}
