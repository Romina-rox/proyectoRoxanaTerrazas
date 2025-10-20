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
            $table->string('numero_activo')->unique(); // Número de identificación del equipo
            $table->text('descripcion_problema'); // Lo que reporta el usuario
            $table->text('descripcion_equipo'); // Detalles específicos del equipo (ej: "Epson L355")
            $table->text('detalle_salida')->nullable(); // Qué se hizo para repararlo
            $table->date('fecha_ingreso');
            $table->date('fecha_salida')->nullable();
            
            // Estados del ticket actualizados
            $table->enum('estado', ['en_espera', 'aceptado', 'reparado', 'baja', 'devuelto'])
                  ->default('en_espera');
            
            // Fechas para control de tiempo
            $table->timestamp('fecha_aceptacion')->nullable(); // Cuando se acepta el ticket
            $table->timestamp('fecha_finalizacion')->nullable(); // Cuando se marca como reparado/baja
            $table->timestamp('fecha_devolucion')->nullable(); // Cuando se devuelve al usuario
            
            // Control de alertas de tiempo
            $table->boolean('alerta_tiempo')->default(false); // Si excede 4 días
            $table->integer('dias_transcurridos')->default(0); // Días entre aceptación y finalización
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};