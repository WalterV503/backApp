<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_usuario');
            $table->string('password');
            $table->string('email')->unique();
            $table->date('fecha_nacimiento');
            $table->string('genero');
            $table->string('telefono', 9);
            $table->string('nombre');
            $table->string('apellido');
            $table->string('direccion');
            //Agregamos estos campos
            $table->string('foto_perfil');
            $table->string('foto_portada');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
