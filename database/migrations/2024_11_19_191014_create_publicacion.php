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
        Schema::create('publicacion', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fk_usuario_id');
            $table->foreign('fk_usuario_id')->references('id')->on('usuario')->onDelete('cascade');
            $table->text('contenido');
            $table->string('url_publicacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publicacion');
    }
};
