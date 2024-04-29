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
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('folio')->nullable();
            $table->string('personal_dirigido')->nullable();
            $table->unsignedBigInteger('carpeta_id');
            $table->string('ubicacion')->nullable();
            $table->string('descripcion')->nullable();
            $table->timestamps();

            $table->foreign('carpeta_id')
                            ->references('id')
                            ->on('carpetas')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
