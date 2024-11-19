<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReaccionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reaccion')->insert([
            'fk_usuario_id' => 1,
            'fk_publicacion_id' => 1,
            'fk_tipoReaccion_id' => 1,
            'fecha_reaccion' => now()
        ]);
    }
}
