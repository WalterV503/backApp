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
        DB::table('usuario')->insert([
            'nombre_usuario' => 'Ernesto Vasquez',
            'password' => '12345678',
            'email' => 'ernesto@itca.edu.sv',
            'telefono' => '6545-6545',
            'direccion' => 'San Salvador Sur',
            'fecha_nacimiento' => '2003-10-06',
            'genero' => 'Masculino',
            'nombre' => 'Ernesto',
            'apellido' => 'Vasquez',
            'foto_perfil' => 'storage/photos/example1.jpg',
            'foto_portada' => 'storage/photos/example1.jpg'
        ]);

        DB::table('usuario')->insert([
            'nombre_usuario' => 'Walter Vasquez',
            'password' => '12345678',
            'email' => 'walter@itca.edu.sv',
            'telefono' => '6545-6545',
            'direccion' => 'San Salvador Sur',
            'fecha_nacimiento' => '2003-10-06',
            'genero' => 'Masculino',
            'nombre' => 'Walter',
            'apellido' => 'Vasquez',
            'foto_perfil' => 'storage/photos/example1.jpg',
            'foto_portada' => 'storage/photos/example1.jpg'
        ]);
    }
}
