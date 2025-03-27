<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Crear roles 
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'cliente'], ['guard_name' => 'web']);

        // Crea permisos 
        $viewClientsPermission = Permission::firstOrCreate(['name' => 'view clients']);
        $viewReportPermission = Permission::firstOrCreate(['name' => 'view report']);

        // Asignar permisos a admin
        $adminRole->givePermissionTo([$viewClientsPermission, $viewReportPermission]);

        //Asignar rol al usuario con ID 1
        $user = User::find(1);
        if($user && !$user->hasRole('admin')){
            $user->assignRole($adminRole);
        }

        // Asignar rol "cliente" a todos los demás usuarios que no sean admin
        $users = User::where('id', '!=', 1)->get();
        foreach ($users as $user) {
            if (!$user->hasRole('admin') && !$user->hasRole('cliente')) {
                $user->assignRole($clientRole);
            }
        }

    }
}
