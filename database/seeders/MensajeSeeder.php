<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MensajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mensaje')->insert([
            'fk_usuario_emisor_id' => 1,
            'fk_usuario_receptor_id' => 2,
            'contenido' => 'Hola, esto es un mensaje de prueba',
            'estado' => 'pendiente',
            'tipo_mensaje' => 'texto',
            'fecha_envio' => now(),
        ]);
    }
}
