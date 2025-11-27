<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administrativos', function (Blueprint $table) {
            $table->id();

             $table->unsignedBigInteger('usuario_id'); 

            $table->foreign('usuario_id')->references('id')->on('users') ->onDelete('cascade'); 
        
            $table->string('nombres');
            $table->string('apellidos');
             $table->text('ci')->change(); 
            $table->date('fecha_nacimiento');
            $table->string('telefono');
            $table->string('direccion');
            $table->string('profesion');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('administrativos', function (Blueprint $table) {
            $table->string('ci', 1000)->change();
        });
    }
};
