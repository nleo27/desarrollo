<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'dni' => '47239393',
                'name' => ' Nilton Sergio',
                'apellidos' => 'Risco Collazos',
                'telefono' => '902541254',
                'area_id' => '1',
                'email' => 'niltonrisco@gmail.com',
                'rol' => 'Administrador',
                'password' => bcrypt('123456789'),
            ],

            [
                'dni' => '47239391',
                'name' => ' Juan José',
                'apellidos' => 'Sandoval Piscoya',
                'telefono' => '902541258',
                'area_id' => '2',
                'email' => 'jsandoval@gmail.com',
                'rol' => 'Usuario',
                'password' => bcrypt('123456789'),
            ],

            [
                'dni' => '47239000',
                'name' => ' María',
                'apellidos' => 'Sandoval Piscoya',
                'telefono' => '902541274',
                'area_id' => '2',
                'email' => 'msandoval@gmail.com',
                'rol' => 'Jefe',
                'password' => bcrypt('123456789'),
            ]

            ]);
    }
}
