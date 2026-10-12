<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('reparaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained(); // Técnico asignado (Tú o tu primo)
            $table->enum('estado', [
                'recepcion', 
                'diagnostico', 
                'cotizacion', 
                'esperando_piezas', 
                'en_reparacion', 
                'pruebas', 
                'listo_entrega', 
                'entregado'
            ])->default('recepcion');
            
            $table->text('diagnostico_tecnico')->nullable();
            $table->decimal('costo_estimado', 10, 2)->nullable();
            $table->decimal('costo_final', 10, 2)->nullable();
            $table->integer('dias_garantia')->default(30);
            
            $table->timestamp('fecha_ingreso')->useCurrent();
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void { 
        Schema::dropIfExists('reparaciones'); 
    }
};