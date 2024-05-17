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
        Schema::create('archivos_grupos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->nullable();
            $table->string('ruta_archivo')->nullable();
            $table->unsignedBigInteger('grupo_area_id');
            $table->string('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('grupo_area_id')
                            ->references('grupo_id')
                            ->on('grupo_area')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_grupos');
    }
};
