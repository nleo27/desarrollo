<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Usuario::create([
            'dni' => '47239393',
            'name' => 'Nilton Sergio',
            'apellidos' => 'Risco Collazos',
            'telefono' => '902541254',
            'area_id' => null,
            'email' => 'niltonrisco@gmail.com',
            'password' => bcrypt('123456789'),
        ])->assignRole('Administrador');
            
    }
}
