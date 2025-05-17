<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_asistencias_table.php
public function up()
{
    Schema::create('asistencias', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('maestro_id');
        $table->unsignedBigInteger('periodo_id');
        $table->date('fecha');
        $table->enum('asistio', ['presente', 'ausente', 'justificado']);
        $table->text('observaciones')->nullable();
        $table->timestamps();

        $table->foreign('maestro_id')->references('id')->on('maestros')->onDelete('cascade');
        $table->foreign('periodo_id')->references('id')->on('periodos')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};
