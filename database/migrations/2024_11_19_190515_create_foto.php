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
        Schema::create('foto', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_usuario_id');
            $table->unsignedBigInteger('fk_tipoFoto_id');
            $table->string('url_foto');
            $table->dateTime('fecha_subida');
            $table->foreign('fk_usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('fk_tipoFoto_id')->references('id')->on('tipo_foto')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto');
    }
};
