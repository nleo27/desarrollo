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
        Schema::table('cartas', function (Blueprint $table) {
            // Cambiar el tipo de columna `dirigido` a `unsignedBigInteger`
            $table->unsignedBigInteger('dirigido')->change();

            // Agregar la clave foránea
            $table->foreign('dirigido')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cartas', function (Blueprint $table) {
            // Eliminar la clave foránea
            $table->dropForeign(['dirigido']);

            // Revertir el tipo de la columna a VARCHAR
            $table->string('dirigido')->change();
        });
    }
};
