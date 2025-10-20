<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $table ='hospitals';
    protected $fillable = [
        'nombre',
        'tipo',
        'telefono',
        'direccion',
    ];
    // Relación con usuarios (un hospital tiene muchos usuarios)
    public function usuarios()
    {
        return $this->hasMany(Usuario::class);
    }
}