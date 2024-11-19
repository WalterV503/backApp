<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PublicacionFotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('publicacion_foto')->insert([
            'fk_publicacion_id' => 1,
            'fk_foto_id' => 1
        ]);
    }
}
