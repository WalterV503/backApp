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
        Schema::create('mensaje', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_usuario_emisor_id');
            $table->unsignedBigInteger('fk_usuario_receptor_id');
            $table->text('contenido');
            $table->enum('estado', ['pendiente', 'leido'])->default('pendiente');
            $table->enum('tipo_mensaje', ['texto', 'imagen', 'archivo'])->default('texto');
            $table->unsignedBigInteger('referencia_mensaje')->nullable();
            $table->dateTime('fecha_envio')->useCurrent();

            $table->foreign('fk_usuario_emisor_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('fk_usuario_receptor_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('referencia_mensaje')->references('id')->on('mensaje')->onDelete('set null');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mensaje');
    }
};
