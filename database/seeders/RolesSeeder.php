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
        //Crear roles solo si no existen
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'cliente'], ['guard_name' => 'web']);

        //Asignar rol al usuario con ID 1
        $user = User::find(1);
        if($user && !$user->hasRole('admin')){
            $user->assignRole($adminRole);
        }

    }
}
