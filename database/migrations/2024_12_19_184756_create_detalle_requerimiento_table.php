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
        Schema::create('detalle_requerimiento', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_requerimiento');
            $table->string('archivo');
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Definir la clave foránea
            $table->foreign('id_requerimiento')
                  ->references('id')
                  ->on('requerimientos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_requerimiento');
    }
};
