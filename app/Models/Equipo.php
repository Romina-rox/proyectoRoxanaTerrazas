<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipos';

    protected $fillable = [
        'nombre',
    ];
    // Relación con tickets (un tipo de equipo puede tener muchos tickets)
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    
    // Contar tickets por estado para este tipo de equipo
    public function ticketsAceptados()
    {
        return $this->tickets()->where('estado', 'aceptado');
    }
    
    public function ticketsEnReparacion()
    {
        return $this->tickets()->where('estado', 'en_reparacion');
    }
    
    public function ticketsReparados()
    {
        return $this->tickets()->where('estado', 'reparado');
    }
    
    public function ticketsDadosDeBaja()
    {
        return $this->tickets()->where('estado', 'dado_de_baja');
    }

}
