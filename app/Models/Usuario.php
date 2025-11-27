<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

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

    // ⭐ ACCESSOR: Descifra automáticamente al leer
    public function getCiAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value; // Si no está cifrado, devuelve el valor original
        }
    }

    // ⭐ MUTATOR: Cifra automáticamente al guardar
    public function setCiAttribute($value)
    {
        $this->attributes['ci'] = Crypt::encryptString($value);
    }

    // Relación con el modelo User
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