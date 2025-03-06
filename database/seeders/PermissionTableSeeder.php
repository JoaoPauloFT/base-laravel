<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'code' => 'list_user',
                'view' => 'user'
            ],
            [
                'code' => 'create_user',
                'view' => 'user'
            ],
            [
                'code' => 'edit_user',
                'view' => 'user'
            ],
            [
                'code' => 'delete_user',
                'view' => 'user'
            ],
            [
                'code' => 'list_role',
                'view' => 'role'
            ],
            [
                'code' => 'create_role',
                'view' => 'role'
            ],
            [
                'code' => 'edit_role',
                'view' => 'role'
            ],
            [
                'code' => 'delete_role',
                'view' => 'role'
            ],
        ]);
    }
}
