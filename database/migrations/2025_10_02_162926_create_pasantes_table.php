<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pasantes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('nombres');
            $table->string('apellidos');
            $table->string('ci')->nullable();
            $table->string('fecha_nacimiento');
            $table->string('celular')->nullable();
            $table->string('ref_celular')->nullable();
            $table->string('parentesco')->nullable();
            
            $table->string('universidad');
            $table->string('carrera');
            $table->string('email')->unique();
            $table->string('foto');
            $table->enum('estado', ['activo', 'inactivo'])->default('activo');
          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasantes');
    }
};
