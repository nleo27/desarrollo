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
        Schema::create('grupo_area', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('grupo_id');
            $table->unsignedBigInteger('area_id')->nullable();;
            $table->timestamps();

            $table->foreign('grupo_id')
                            ->references('id')
                            ->on('grupos')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');

            $table->foreign('area_id')
                            ->references('id')
                            ->on('areas')
                            ->onUpdate('cascade') 
                            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_area');
    }
};
