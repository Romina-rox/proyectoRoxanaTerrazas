<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            
            // Relación con usuario que trae el equipo
            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')
                  ->references('id')
                  ->on('usuarios')
                  ->onDelete('cascade');
            
            // Relación con tipo de equipo
            $table->unsignedBigInteger('equipo_id');
            $table->foreign('equipo_id')
                  ->references('id')
                  ->on('equipos')
                  ->onDelete('cascade');
            
            // Datos del ticket
            $table->string('numero_activo'); // YA NO ES UNIQUE - puede repetirse
            $table->text('descripcion_problema');
            $table->text('descripcion_equipo');
            $table->text('detalle_salida')->nullable();
            $table->date('fecha_ingreso');
            $table->date('fecha_salida')->nullable();
            
            // Estados actualizados
            $table->enum('estado', [
                'en_espera', 
                'aceptado', 
                'reparado',              // Listo para devolver al usuario
                'baja',                  // Dado de baja, va a Activos Fijos
                'devuelto_usuario',      // Entregado al usuario (solo reparados)
                'entregado_activos_fijos' // Entregado a Activos Fijos (solo bajas)
            ])->default('en_espera');
            
            // Fechas para control de tiempo
            $table->timestamp('fecha_aceptacion')->nullable();
            $table->timestamp('fecha_finalizacion')->nullable();
            $table->timestamp('fecha_devolucion_usuario')->nullable(); // Cuando va al usuario
            $table->timestamp('fecha_entrega_activos_fijos')->nullable(); // Cuando va a Activos Fijos
            
            // Control de alertas de tiempo
            $table->boolean('alerta_tiempo')->default(false);
            $table->integer('dias_transcurridos')->default(0);
            
            $table->timestamps();
            
            // Índice para búsqueda de historial por número de activo
            $table->index('numero_activo');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};