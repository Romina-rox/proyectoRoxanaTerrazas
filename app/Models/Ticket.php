<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Ticket extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'usuario_id',
        'equipo_id',
        'numero_activo',
        'descripcion_problema',
        'descripcion_equipo',
        'detalle_salida',
        'fecha_ingreso',
        'fecha_salida',
        'estado',
        'fecha_aceptacion',
        'fecha_finalizacion',
        'fecha_devolucion_usuario',      // ✅ CAMBIADO
        'fecha_entrega_activos_fijos',   // ✅ NUEVO
        'alerta_tiempo',
        'dias_transcurridos'
    ];

    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_salida' => 'date',
        'fecha_aceptacion' => 'datetime',
        'fecha_finalizacion' => 'datetime',
        'fecha_devolucion_usuario' => 'datetime',      // ✅ CAMBIADO
        'fecha_entrega_activos_fijos' => 'datetime',   // ✅ NUEVO
        'alerta_tiempo' => 'boolean'
    ];

    // Relaciones
    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function getHospitalAttribute()
    {
        return $this->usuario->hospital;
    }

    // Scopes
    public function scopeEnEspera($query)
    {
        return $query->where('estado', 'en_espera');
    }

    public function scopeAceptados($query)
    {
        return $query->where('estado', 'aceptado');
    }

    public function scopeReparados($query)
    {
        return $query->where('estado', 'reparado');
    }

    public function scopeBaja($query)
    {
        return $query->where('estado', 'baja');
    }

    // ✅ SCOPES ACTUALIZADOS
    public function scopeDevueltosUsuario($query)
    {
        return $query->where('estado', 'devuelto_usuario');
    }

    public function scopeEntregadosActivosFijos($query)
    {
        return $query->where('estado', 'entregado_activos_fijos');
    }

    public function scopeConAlerta($query)
    {
        return $query->where('alerta_tiempo', true)
                     ->where('estado', 'aceptado'); 
    }

    // ✅ SCOPES NUEVOS PARA PENDIENTES
    public function scopePendientesDevolucionUsuario($query)
    {
        return $query->where('estado', 'reparado');
    }

    public function scopePendientesActivosFijos($query)
    {
        return $query->where('estado', 'baja');
    }

    // Accessors
    public function getEstadoHumanoAttribute()
    {
        return match($this->estado) {
            'en_espera' => 'En Espera',
            'aceptado' => 'Aceptado',
            'reparado' => 'Reparado',
            'baja' => 'Dado de Baja',
            'devuelto_usuario' => 'Devuelto al Usuario',
            'entregado_activos_fijos' => 'Entregado a Activos Fijos',
            default => 'Estado Desconocido'
        };
    }

    public function getEstadoColorAttribute()
    {
        return match($this->estado) {
            'en_espera' => 'secondary',
            'aceptado' => 'info',
            'reparado' => 'success',
            'baja' => 'danger',
            'devuelto_usuario' => 'primary',
            'entregado_activos_fijos' => 'warning',
            default => 'secondary'
        };
    }

    public function calcularDiasTranscurridos()
    {
        if (!$this->fecha_aceptacion) {
            return 0;
        }

        $fechaFin = $this->fecha_finalizacion ?? now();
        return $this->fecha_aceptacion->diffInDays($fechaFin);
    }

    public function verificarAlertaTiempo()
    {
        if ($this->estado !== 'aceptado') {
            $this->alerta_tiempo = false;
            $this->dias_transcurridos = 0;
            $this->save();
            return false;
        }

        $dias = $this->calcularDiasTranscurridos();
        $this->dias_transcurridos = $dias;
        $this->alerta_tiempo = $dias > 3; 
        $this->save();
        
        return $this->alerta_tiempo;
    }

    // ✅ MÉTODO ACTUALIZADO
    public function cambiarEstado($nuevoEstado, $detalleSalida = null)
    {
        $this->estado = $nuevoEstado;
        
        switch ($nuevoEstado) {
            case 'aceptado':
                $this->fecha_aceptacion = now();
                break;
                
            case 'reparado':
            case 'baja':
                $this->fecha_finalizacion = now();
                $this->fecha_salida = now()->toDateString();
                if ($detalleSalida) {
                    $this->detalle_salida = $detalleSalida;
                }
                $this->dias_transcurridos = $this->calcularDiasTranscurridos();
                $this->alerta_tiempo = false;
                break;
                
            // ✅ CASOS ACTUALIZADOS
            case 'devuelto_usuario':
                $this->fecha_devolucion_usuario = now();
                if ($detalleSalida) {
                    $this->detalle_salida .= "\n[Devuelto al Usuario: " . now()->format('d/m/Y H:i') . "] " . $detalleSalida;
                }
                $this->alerta_tiempo = false;
                break;

            case 'entregado_activos_fijos':
                $this->fecha_entrega_activos_fijos = now();
                if ($detalleSalida) {
                    $this->detalle_salida .= "\n[Entregado a Activos Fijos: " . now()->format('d/m/Y H:i') . "] " . $detalleSalida;
                }
                $this->alerta_tiempo = false;
                break;
        }
        
        if ($nuevoEstado === 'aceptado') {
            $this->verificarAlertaTiempo();
        }
        
        $this->save();
    }

    // ✅ ACCESSORS ACTUALIZADOS PARA COMPATIBILIDAD
    public function getEntregadoAttribute()
    {
        return in_array($this->estado, ['devuelto_usuario', 'entregado_activos_fijos']);
    }

    // ✅ ESTE ES EL ACCESSOR CLAVE QUE NECESITAS
    public function getFechaEntregaAttribute()
    {
        // Retorna la fecha que corresponda según el estado
        return $this->fecha_devolucion_usuario ?? $this->fecha_entrega_activos_fijos;
    }

    public function getEntregadoPorAttribute()
    {
        return auth()->user()->name ?? 'Personal Técnico';
    }

    public function getRecibidoPorAttribute()
    {
        return $this->usuario->nombre_completo ?? 'Usuario';
    }

    public function getIconoAlertaAttribute()
    {
        if ($this->alerta_tiempo && $this->estado === 'aceptado') {
            return '<i class="fas fa-exclamation-triangle text-warning" title="Excede 3 días"></i>';
        }
        return '';
    }

    public function getTiempoProcesamiento()
    {
        if (!$this->fecha_aceptacion) {
            return 'No aceptado aún';
        }

        if ($this->fecha_finalizacion) {
            $dias = $this->fecha_aceptacion->diffInDays($this->fecha_finalizacion);
            return $dias . ' día' . ($dias != 1 ? 's' : '');
        }

        $dias = $this->fecha_aceptacion->diffInDays(now());
        return $dias . ' día' . ($dias != 1 ? 's' : '') . ' (en proceso)';
    }

    public function scopeUrgentes($query)
    {
        return $query->where('estado', 'aceptado')
                    ->whereRaw('DATEDIFF(NOW(), fecha_aceptacion) > 3');
    }

    // ✅ MÉTODO NUEVO PARA HISTORIAL
    public static function historialPorActivo($numeroActivo)
    {
        return self::with(['usuario.hospital', 'equipo'])
                   ->where('numero_activo', $numeroActivo)
                   ->orderBy('created_at', 'desc')
                   ->get();
    }
}