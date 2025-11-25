<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Hospital;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReporteController extends Controller
{
    /**
     * Dashboard principal de reportes
     */
    public function index(Request $request)
    {
        // ESTADÍSTICAS GENERALES
        $estadisticasGenerales = [
            'total_tickets' => Ticket::count(),
            'total_reparados' => Ticket::where('estado', 'devuelto_usuario')->count(),
            'total_bajas' => Ticket::where('estado', 'entregado_activos_fijos')->count(),
            'en_proceso' => Ticket::where('estado', 'aceptado')->count(),
            'en_espera' => Ticket::where('estado', 'en_espera')->count(),
        ];

        // TICKETS POR MES (últimos 12 meses)
        $ticketsPorMes = $this->getTicketsPorMes();

        // TICKETS POR AÑO
        $ticketsPorAño = $this->getTicketsPorAño();

        // TOP 5 HOSPITALES
        $topHospitales = $this->getTopHospitales();

        // EQUIPOS MÁS RECIBIDOS
        $equiposMasRecibidos = $this->getEquiposMasRecibidos();

        // EQUIPOS MÁS DADOS DE BAJA
        $equiposMasBaja = $this->getEquiposMasBaja();

        // DISTRIBUCIÓN POR ESTADO
        $distribucionEstados = $this->getDistribucionEstados();

        // TIEMPO PROMEDIO DE REPARACIÓN
        $tiempoPromedio = $this->getTiempoPromedioReparacion();

        // COMPARATIVA REPARADOS VS BAJAS POR MES
        $comparativaReparadosBajas = $this->getComparativaReparadosBajas();

        return view('admin.reportes.index', compact(
            'estadisticasGenerales',
            'ticketsPorMes',
            'ticketsPorAño',
            'topHospitales',
            'equiposMasRecibidos',
            'equiposMasBaja',
            'distribucionEstados',
            'tiempoPromedio',
            'comparativaReparadosBajas'
        ));
    }

    /**
     * Lista detallada de equipos dados de baja
     */
    public function listadoBajas()
    {
        $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                        ->where('estado', 'entregado_activos_fijos')
                        ->orderBy('fecha_entrega_activos_fijos', 'desc')
                        ->get();

        $estadisticas = [
            'total' => $tickets->count(),
            'este_mes' => $tickets->filter(function($ticket) {
                return $ticket->fecha_entrega_activos_fijos && 
                       $ticket->fecha_entrega_activos_fijos->isCurrentMonth();
            })->count(),
            'este_año' => $tickets->filter(function($ticket) {
                return $ticket->fecha_entrega_activos_fijos && 
                       $ticket->fecha_entrega_activos_fijos->isCurrentYear();
            })->count(),
        ];

        return view('admin.reportes.listado-bajas', compact('tickets', 'estadisticas'));
    }

    /**
     * Lista detallada de equipos devueltos a usuarios
     */
    public function listadoDevueltos()
    {
        $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                        ->where('estado', 'devuelto_usuario')
                        ->orderBy('fecha_devolucion_usuario', 'desc')
                        ->get();

        $estadisticas = [
            'total' => $tickets->count(),
            'este_mes' => $tickets->filter(function($ticket) {
                return $ticket->fecha_devolucion_usuario && 
                       $ticket->fecha_devolucion_usuario->isCurrentMonth();
            })->count(),
            'este_año' => $tickets->filter(function($ticket) {
                return $ticket->fecha_devolucion_usuario && 
                       $ticket->fecha_devolucion_usuario->isCurrentYear();
            })->count(),
        ];

        return view('admin.reportes.listado-devueltos', compact('tickets', 'estadisticas'));
    }

    // ============================================
    // MÉTODOS PRIVADOS PARA OBTENER DATOS
    // ============================================

    private function getTicketsPorMes()
    {
        $meses = [];
        $datos = [];

        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->locale('es')->isoFormat('MMM YYYY');
            
            $datos[] = Ticket::whereYear('created_at', $fecha->year)
                           ->whereMonth('created_at', $fecha->month)
                           ->count();
        }

        return [
            'labels' => $meses,
            'datos' => $datos
        ];
    }

    private function getTicketsPorAño()
    {
        $añoInicio = Ticket::orderBy('created_at', 'asc')->first()->created_at->year ?? now()->year;
        $añoActual = now()->year;

        $años = [];
        $datos = [];

        for ($año = $añoInicio; $año <= $añoActual; $año++) {
            $años[] = $año;
            $datos[] = Ticket::whereYear('created_at', $año)->count();
        }

        return [
            'labels' => $años,
            'datos' => $datos
        ];
    }

    private function getTopHospitales($limit = 5)
    {
        $datos = Ticket::join('usuarios', 'tickets.usuario_id', '=', 'usuarios.id')
                      ->join('hospitals', 'usuarios.hospital_id', '=', 'hospitals.id')
                      ->select('hospitals.nombre', DB::raw('COUNT(*) as total'))
                      ->groupBy('hospitals.nombre')
                      ->orderBy('total', 'desc')
                      ->limit($limit)
                      ->get();

        return [
            'labels' => $datos->pluck('nombre')->toArray(),
            'datos' => $datos->pluck('total')->toArray()
        ];
    }

    private function getEquiposMasRecibidos($limit = 10)
    {
        $datos = Ticket::join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
                      ->select('equipos.nombre', DB::raw('COUNT(*) as total'))
                      ->groupBy('equipos.nombre')
                      ->orderBy('total', 'desc')
                      ->limit($limit)
                      ->get();

        return [
            'labels' => $datos->pluck('nombre')->toArray(),
            'datos' => $datos->pluck('total')->toArray()
        ];
    }

    private function getEquiposMasBaja($limit = 10)
    {
        $datos = Ticket::join('equipos', 'tickets.equipo_id', '=', 'equipos.id')
                      ->where('tickets.estado', 'entregado_activos_fijos')
                      ->select('equipos.nombre', DB::raw('COUNT(*) as total'))
                      ->groupBy('equipos.nombre')
                      ->orderBy('total', 'desc')
                      ->limit($limit)
                      ->get();

        return [
            'labels' => $datos->pluck('nombre')->toArray(),
            'datos' => $datos->pluck('total')->toArray()
        ];
    }

    private function getDistribucionEstados()
    {
        return [
            'labels' => ['En Espera', 'Aceptado', 'Reparado', 'Baja', 'Devuelto Usuario', 'Entregado A.F.'],
            'datos' => [
                Ticket::where('estado', 'en_espera')->count(),
                Ticket::where('estado', 'aceptado')->count(),
                Ticket::where('estado', 'reparado')->count(),
                Ticket::where('estado', 'baja')->count(),
                Ticket::where('estado', 'devuelto_usuario')->count(),
                Ticket::where('estado', 'entregado_activos_fijos')->count(),
            ]
        ];
    }

    private function getTiempoPromedioReparacion()
    {
        $promedio = Ticket::whereNotNull('fecha_finalizacion')
                         ->whereNotNull('fecha_aceptacion')
                         ->avg('dias_transcurridos');

        return round($promedio, 1);
    }

    private function getComparativaReparadosBajas()
    {
        $meses = [];
        $reparados = [];
        $bajas = [];

        for ($i = 11; $i >= 0; $i--) {
            $fecha = now()->subMonths($i);
            $meses[] = $fecha->locale('es')->isoFormat('MMM YYYY');
            
            $reparados[] = Ticket::where('estado', 'devuelto_usuario')
                                ->whereYear('fecha_devolucion_usuario', $fecha->year)
                                ->whereMonth('fecha_devolucion_usuario', $fecha->month)
                                ->count();
            
            $bajas[] = Ticket::where('estado', 'entregado_activos_fijos')
                           ->whereYear('fecha_entrega_activos_fijos', $fecha->year)
                           ->whereMonth('fecha_entrega_activos_fijos', $fecha->month)
                           ->count();
        }

        return [
            'labels' => $meses,
            'reparados' => $reparados,
            'bajas' => $bajas
        ];
    }
}