<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;
    
    protected $table = 'usuarios';

    protected $fillable = [
        'user_id',
        'hospital_id',
        'nombres',
        'apellidos',
        'ci',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'cargo',
        'especialidad'
    ];

    protected $dates = [
        'fecha_nacimiento'
    ];

    // Relación con el modelo User------------------ahhhhhhhhhhhhhhh
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Hospital
    public function hospital()
    {
        return $this->belongsTo(Hospital::class);
    }

    // Accessor para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}