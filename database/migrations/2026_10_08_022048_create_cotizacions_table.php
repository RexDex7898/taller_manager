<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reparacion_id')
                ->constrained('reparaciones')
                ->cascadeOnDelete();

            $table->decimal('subtotal', 10, 2)->default(0);

            $table->decimal('descuento', 10, 2)->default(0);

            $table->decimal('total', 10, 2)->default(0);

            $table->string('estado')->default('Pendiente');

            $table->text('notas')->nullable();

            $table->dateTime('fecha_emision')->nullable();

            $table->dateTime('fecha_autorizacion')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cotizaciones');
    }
};