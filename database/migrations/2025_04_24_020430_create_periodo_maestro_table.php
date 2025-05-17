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
        Schema::create('periodo_maestro', function (Blueprint $table) {
            $table->foreignId('periodo_id')->constrained()->onDelete('cascade');
            $table->foreignId('maestro_id')->constrained()->onDelete('cascade');
            $table->primary(['periodo_id', 'maestro_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('periodo_maestro');
    }
};
