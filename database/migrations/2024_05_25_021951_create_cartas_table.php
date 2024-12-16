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
        Schema::create('cartas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_anio');
            $table->string('nombre_carta');
            $table->date('fecha_carta');
            $table->string('dirigido');
            $table->string('cargo');
            $table->string('institucion')->nullable();
            $table->string('asunto');
            $table->string('referencia')->nullable();
            $table->unsignedBigInteger('id_usuario')->nullable();
            $table->text('mensaje')->nullable();
            $table->date('fecha_caduca')->nullable();
            $table->timestamps();

            $table->foreign('id_usuario')
                            ->references('id')
                            ->on('users')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartas');
    }
};
