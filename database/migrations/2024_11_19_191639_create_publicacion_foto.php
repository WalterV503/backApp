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
        Schema::create('publicacion_foto', function (Blueprint $table) {
            // campos de las claves
            $table->unsignedBigInteger('fk_publicacion_id');
            $table->unsignedBigInteger('fk_foto_id');
            //clave primaria compuesta
            $table->primary(['fk_publicacion_id', 'fk_foto_id']);
            // relaciones
            $table->foreign('fk_publicacion_id')->references('id')->on('publicacion')->onDelete('cascade');
            $table->foreign('fk_foto_id')->references('id')->on('foto')->onDelete('cascade');
            // timestamps para la auditoria
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion_foto');
    }
};
