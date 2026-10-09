<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('consultas', function (Blueprint $table) {
            $table->id();

            $table->string('nombre', 100);
            $table->string('empresa', 120)->nullable();
            $table->string('telefono', 20);
            $table->string('email', 150);
            $table->text('mensaje');

            // Se guarda la marca del consentimiento, no solo el hecho de que se
            // marcó: el RGPD exige poder demostrar cuándo y desde dónde se dio.
            $table->timestamp('consentido_en');
            $table->string('ip', 45)->nullable();

            $table->timestamp('atendida_en')->nullable();
            $table->timestamps();

            // Las consultas se leen siempre por fecha, de la más nueva a la más vieja.
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('consultas');
    }
};
