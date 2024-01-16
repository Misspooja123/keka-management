<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->truncate();
        //
        $password = Hash::make('123456');
        $adminRecords = [
            ['id'=>1, 'name'=>'Admin', 'email'=>'admin@gmail.com', 'password'=>$password],

        ];
        Admin::insert($adminRecords);
    }
}
