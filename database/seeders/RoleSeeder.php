<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1= Role::create(['name' => 'Administrador']);
        $role2= Role::create(['name' => 'Jefe']);
        $role3= Role::create(['name' => 'Usuario']);

        Permission:: create(['name' => 'home'])->syncRoles([$role1, $role2, $role3]);

        Permission:: create(['name' => 'create_usuario.index'])->syncRoles([$role1, $role2]);
        Permission:: create(['name' => 'create_usuario.create'])->syncRoles([$role1]);
        Permission:: create(['name' => 'create_usuario.editar'])->syncRoles([$role1]);
        Permission:: create(['name' => 'create_usuario.eliminar'])->syncRoles([$role1]);

        Permission:: create(['name' => 'create_area.index'])->syncRoles([$role1, $role2]);
        Permission:: create(['name' => 'create_area.create'])->syncRoles([$role1]);
        Permission:: create(['name' => 'create_area.editar'])->syncRoles([$role1]);
        Permission:: create(['name' => 'create_area.eliminar'])->syncRoles([$role1]);

        Permission:: create(['name' => 'create_periodo.index'])->syncRoles([$role1, $role2, $role3]);
        Permission:: create(['name' => 'create_periodo.create'])->syncRoles([$role1]);
        Permission:: create(['name' => 'create_periodo.editar'])->syncRoles([$role1]);
        Permission:: create(['name' => 'create_periodo.eliminar'])->syncRoles([$role1]);

        Permission:: create(['name' => 'documento.crear.index'])->syncRoles([$role1, $role2, $role3]);
        Permission:: create(['name' => 'documento.crear.create'])->syncRoles([$role1, $role2, $role3]);
        Permission:: create(['name' => 'documento.crear.editar'])->syncRoles([$role1]);
        Permission:: create(['name' => 'documento.crear.eliminar'])->syncRoles([$role1]);
    }
}
