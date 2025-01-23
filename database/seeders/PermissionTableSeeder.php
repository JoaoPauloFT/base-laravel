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
                'name' => 'Listar Usuários',
                'code' => 'list_user',
                'view' => 'user'
            ],
            [
                'name' => 'Criar Usuário',
                'code' => 'create_user',
                'view' => 'user'
            ],
            [
                'name' => 'Editar Usuário',
                'code' => 'edit_user',
                'view' => 'user'
            ],
            [
                'name' => 'Deletar Usuário',
                'code' => 'delete_user',
                'view' => 'user'
            ],
            [
                'name' => 'Listar Funções',
                'code' => 'list_role',
                'view' => 'role'
            ],
            [
                'name' => 'Criar Funções',
                'code' => 'create_role',
                'view' => 'role'
            ],
            [
                'name' => 'Editar Funções',
                'code' => 'edit_role',
                'view' => 'role'
            ],
            [
                'name' => 'Deletar Funções',
                'code' => 'delete_role',
                'view' => 'role'
            ],
        ]);
    }
}
