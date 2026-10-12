<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cliente_id')->constrained('clientes')->cascadeOnDelete();
            $table->string('tipo')->default('Celular');
            $table->string('marca');
            $table->string('modelo');
            $table->string('imei')->nullable();
            $table->string('numero_serie')->nullable();
            $table->string('color')->nullable();
            $table->string('contrasena')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipos');
    }
};