<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\FotoSeeder;
use Database\Seeders\MensajeSeeder;
use Database\Seeders\UsuarioSeeder;
use Database\Seeders\ReaccionSeeder;
use Database\Seeders\TipoFotoSeeder;
use Database\Seeders\PublicacionSeeder;
use Database\Seeders\TipoReaccionSeeder;
use Database\Seeders\PublicacionFotoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            UsuarioSeeder::class,
            TipoFotoSeeder::class,
            FotoSeeder::class,
            PublicacionSeeder::class,
            PublicacionFotoSeeder::class,
            MensajeSeeder::class,
            TipoReaccionSeeder::class,
            ReaccionSeeder::class,
        ]);
    }
}
