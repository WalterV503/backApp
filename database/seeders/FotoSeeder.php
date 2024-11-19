<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('foto')->insert([
            'fk_usuario_id' => 1,
            'fk_tipoFoto_id' => 1,
            'url_foto' => 'storage/photos/example1.jpg',
            'fecha_subida' => now()
        ]);
    }
}
