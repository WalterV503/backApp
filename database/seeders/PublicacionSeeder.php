<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publicacion')->insert([
            'fk_usuario_id' => 1,
            'contenido' => 'Este es un mensaje de prueba de publicacion',
            'url_publicacion' => ''
        ]);
    }
}
