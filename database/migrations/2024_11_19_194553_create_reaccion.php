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
        Schema::create('reaccion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_usuario_id');
            $table->unsignedBigInteger('fk_publicacion_id');
            $table->unsignedBigInteger('fk_tipoReaccion_id');
            $table->dateTime('fecha_reaccion')->useCurrent();

            $table->foreign('fk_usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->foreign('fk_publicacion_id')->references('id')->on('publicacion')->onDelete('cascade');
            $table->foreign('fk_tipoReaccion_id')->references('id')->on('tipo_reaccion')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reaccion');
    }
};
