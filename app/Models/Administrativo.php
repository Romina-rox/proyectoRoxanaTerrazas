<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Administrativo extends Model
{
    use HasFactory;
    
    protected $table = 'administrativos';
    
    protected $fillable = [
        'usuario_id',
        'nombres',
        'apellidos',
        'ci',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'profesion',
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
            // Si no está cifrado o hay error, devuelve el valor original
            return $value;
        }
    }

    // ⭐ MUTATOR: Cifra automáticamente al guardar
    public function setCiAttribute($value)
    {
        $this->attributes['ci'] = Crypt::encryptString($value);
    }

    // Relación con el modelo User
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Accessor para obtener el nombre completo
    public function getNombreCompletoAttribute()
    {
        return $this->nombres . ' ' . $this->apellidos;
    }
}