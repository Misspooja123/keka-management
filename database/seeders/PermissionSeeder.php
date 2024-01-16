<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        $modules = ['dashboard', 'attendance', 'leave', 'department', 'employee', 'marksheet', 'role' , 'adminuser'];
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($modules as $module) {
            foreach ($actions as $action) {
                DB::table('permissions')->insert([
                    'name' => $module . '_' . $action,
                    'guard_name' => 'admin',
                    'module' => $module,
                ]);
            }
        }
    }


}
