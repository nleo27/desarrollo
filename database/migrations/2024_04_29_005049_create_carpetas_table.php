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
        Schema::create('carpetas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('modulo')->nullable();
            $table->string('estante')->nullable();
            $table->string('codigo')->nullable();
            $table->string('descipcion')->nullable();
            $table->unsignedBigInteger('carpeta_padre_id')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('id_area');
            $table->unsignedBigInteger('id_periodo');
            $table->timestamps();

            $table->foreign('carpeta_padre_id')
                            ->references('id')
                            ->on('carpetas')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');

            $table->foreign('user_id')
                            ->references('id')
                            ->on('users')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');

            $table->foreign('id_area')
                            ->references('id')
                            ->on('areas')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');

            $table->foreign('id_periodo')
                            ->references('id')
                            ->on('periodos')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carpetas');
    }
};
