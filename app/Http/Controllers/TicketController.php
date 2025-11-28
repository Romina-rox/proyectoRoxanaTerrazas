<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Usuario;
use App\Models\Equipo;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $ticketsAceptados = Ticket::aceptados()->get();
        foreach ($ticketsAceptados as $ticket) {
            $ticket->verificarAlertaTiempo();
        }
        
        if ($user->hasRole('usuario')) {
            $tickets = Ticket::with(['usuario', 'equipo'])
                           ->whereHas('usuario', function($query) use ($user) {
                               $query->where('user_id', $user->id);
                           })
                           ->orderBy('created_at', 'desc')
                           ->get();
        } else {
            $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                           ->orderBy('created_at', 'desc')
                           ->get();
        }
        
        return view('admin.tickets.index', compact('tickets'));
    }

    public function create()
    {
        $equipos = Equipo::all();
        $user = Auth::user();
        
        $usuario = Usuario::where('user_id', $user->id)->first();
        
        if (!$usuario) {
            return redirect()->route('admin.tickets.index')
                ->with('mensaje', 'Debe tener un perfil de usuario para crear tickets')
                ->with('icono', 'error');
        }
        
        return view('admin.tickets.create', compact('equipos', 'usuario'));
    }

    public function store(Request $request)
    {
        try {
            // Validación SIN unique en numero_activo
            $request->validate([
                'equipo_id' => 'required|exists:equipos,id',
                'numero_activo' => 'required', // YA NO ES UNIQUE
                'descripcion_problema' => 'required|string|max:1000',
                'descripcion_equipo' => 'required|string|max:1000',
                'fecha_ingreso' => 'required|date'
            ]);

            $user = Auth::user();
            $usuario = Usuario::where('user_id', $user->id)->first();

            if (!$usuario) {
                return redirect('/admin/tickets')
                    ->with('mensaje', 'Error: No se encontró su perfil de usuario.')
                    ->with('icono', 'error');
            }

            Ticket::create([
                'usuario_id' => $usuario->id,
                'equipo_id' => $request->equipo_id,
                'numero_activo' => $request->numero_activo,
                'descripcion_problema' => $request->descripcion_problema,
                'descripcion_equipo' => $request->descripcion_equipo,
                'fecha_ingreso' => $request->fecha_ingreso,
                'estado' => 'en_espera',
            ]);

            return redirect('/admin/tickets')
                ->with('mensaje', 'Ticket creado correctamente.')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            return redirect('/admin/tickets')
                ->with('mensaje', 'Error al crear el ticket.')
                ->with('icono', 'error');
        }
    }

    public function show($id)
    {
        $ticket = Ticket::with(['usuario.hospital', 'equipo'])->findOrFail($id);
        return view('admin.tickets.show', compact('ticket'));
    }

    public function edit($id)
    {
        $ticket = Ticket::with(['usuario', 'equipo'])->findOrFail($id);
        $equipos = Equipo::all();
        
        return view('admin.tickets.edit', compact('ticket', 'equipos'));
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);
        
        $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'numero_activo' => 'required',
            'descripcion_problema' => 'required',
            'descripcion_equipo' => 'required',
            'detalle_salida' => 'nullable',
            'fecha_ingreso' => 'required|date',
            'fecha_salida' => 'nullable|date',
            'estado' => 'required|in:en_espera,aceptado,reparado,baja,devuelto_usuario,entregado_activos_fijos' 
        ]);

        $estadoAnterior = $ticket->estado;
        
        $ticket->equipo_id = $request->equipo_id;
        $ticket->numero_activo = $request->numero_activo;
        $ticket->descripcion_problema = $request->descripcion_problema;
        $ticket->descripcion_equipo = $request->descripcion_equipo;
        $ticket->fecha_ingreso = $request->fecha_ingreso;
        
        if ($estadoAnterior !== $request->estado) {
            $ticket->cambiarEstado($request->estado, $request->detalle_salida);
        } else {
            $ticket->detalle_salida = $request->detalle_salida;
            $ticket->fecha_salida = $request->fecha_salida;
            $ticket->save();
        }

        return redirect('/admin/tickets')
            ->with('mensaje', 'Ticket actualizado correctamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect('/admin/tickets')
            ->with('mensaje', 'Ticket eliminado correctamente')
            ->with('icono', 'success');
    }

    public function aceptarTicket($id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            if ($ticket->estado !== 'en_espera') {
                return redirect()->back()->with('mensaje', 'Solo tickets en espera pueden aceptarse.')->with('icono', 'error');
            }
            $ticket->cambiarEstado('aceptado');
            return redirect('/admin/tickets')
                ->with('mensaje', 'Ticket aceptado correctamente.')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('mensaje', 'Error al aceptar ticket')->with('icono', 'error');
        }
    }

    // DEVOLVER AL USUARIO (solo reparados)
    public function marcarDevueltoUsuario(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            if ($ticket->estado !== 'reparado') {
                return redirect()->back()->with('mensaje', 'Solo tickets reparados pueden devolverse al usuario')->with('icono', 'error');
            }
            $ticket->cambiarEstado('devuelto_usuario', $request->detalle_devolucion ?? null);
            return redirect('/admin/tickets')
                ->with('mensaje', 'Equipo devuelto al usuario correctamente.')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('mensaje', 'Error al devolver')->with('icono', 'error');
        }
    }

    // ENTREGAR A ACTIVOS FIJOS (solo dados de baja)
    public function marcarEntregadoActivosFijos(Request $request, $id)
    {
        try {
            $ticket = Ticket::findOrFail($id);
            if ($ticket->estado !== 'baja') {
                return redirect()->back()->with('mensaje', 'Solo equipos dados de baja se entregan a Activos Fijos')->with('icono', 'error');
            }
            $ticket->cambiarEstado('entregado_activos_fijos', $request->detalle_entrega ?? null);
            return redirect('/admin/tickets')
                ->with('mensaje', 'Equipo entregado a Activos Fijos correctamente.')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('mensaje', 'Error al entregar')->with('icono', 'error');
        }
    }

    // Comprobante para usuario (solo reparados devueltos)
    public function comprobanteUsuario($id)
    {
        $ticket = Ticket::with(['usuario.hospital', 'equipo'])->findOrFail($id);
        if ($ticket->estado !== 'devuelto_usuario') {
            return redirect()->back()->with('mensaje', 'Solo equipos devueltos al usuario tienen comprobante')->with('icono', 'error');
        }
        return view('admin.tickets.comprobante-usuario', compact('ticket'));
    }

    // Comprobante para Activos Fijos (solo bajas entregadas)
    public function comprobanteActivosFijos($id)
    {
        $ticket = Ticket::with(['usuario.hospital', 'equipo'])->findOrFail($id);
        if ($ticket->estado !== 'entregado_activos_fijos') {
            return redirect()->back()->with('mensaje', 'Solo equipos entregados a Activos Fijos tienen comprobante')->with('icono', 'error');
        }
        return view('admin.tickets.comprobante-activos-fijos', compact('ticket'));
    }

    // PENDIENTES DE DEVOLUCIÓN AL USUARIO
    public function pendientesUsuario()
    {
        try {
            $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                        ->where('estado', 'reparado')
                        ->orderBy('fecha_salida', 'asc')
                        ->get();

            return view('admin.tickets.pendientes-usuario', compact('tickets'));
        } catch (\Exception $e) {
            return redirect('/admin/tickets')
                ->with('mensaje', 'Error al cargar tickets pendientes.')
                ->with('icono', 'error');
        }
    }

    // PENDIENTES DE ENTREGA A ACTIVOS FIJOS
    public function pendientesActivosFijos()
    {
        try {
            $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                        ->where('estado', 'baja')
                        ->orderBy('fecha_salida', 'asc')
                        ->get();

            return view('admin.tickets.pendientes-activos-fijos', compact('tickets'));
        } catch (\Exception $e) {
            return redirect('/admin/tickets')
                ->with('mensaje', 'Error al cargar tickets pendientes.')
                ->with('icono', 'error');
        }
    }

    public function alertaTiempo()
    {
        $ticketsAceptados = Ticket::where('estado', 'aceptado')->get();
        
        foreach ($ticketsAceptados as $ticket) {
            $ticket->verificarAlertaTiempo();
        }

        $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                       ->where('estado', 'aceptado')
                       ->where('alerta_tiempo', true)
                       ->orderBy('fecha_aceptacion', 'asc')
                       ->get();
        
        return view('admin.tickets.alerta-tiempo', compact('tickets'));
    }

    // HISTORIAL DE EQUIPOS (reemplaza dashboard)
    public function historial(Request $request)
    {
        $query = Ticket::with(['usuario.hospital', 'equipo']);
        
        // Filtro por número de activo
        if ($request->filled('numero_activo')) {
            $query->where('numero_activo', 'LIKE', '%' . $request->numero_activo . '%');
        }
        
        // Filtro por hospital
        if ($request->filled('hospital_id')) {
            $query->whereHas('usuario', function($q) use ($request) {
                $q->where('hospital_id', $request->hospital_id);
            });
        }
        
        $tickets = $query->orderBy('created_at', 'desc')->get();
        
        // Agrupar por número de activo para estadísticas
        $estadisticasPorActivo = [];
        if ($request->filled('numero_activo')) {
            $ticketsMismoActivo = Ticket::where('numero_activo', $request->numero_activo)
                                       ->orderBy('created_at', 'desc')
                                       ->get();
            
            if ($ticketsMismoActivo->count() > 0) {
                $estadisticasPorActivo = [
                    'numero_activo' => $request->numero_activo,
                    'total_visitas' => $ticketsMismoActivo->count(),
                    'hospital' => $ticketsMismoActivo->first()->hospital->nombre ?? 'N/A',
                    'tickets' => $ticketsMismoActivo
                ];
            }
        }
        
        $hospitales = Hospital::orderBy('nombre')->get();
        
        return view('admin.tickets.historial', compact('tickets', 'hospitales', 'estadisticasPorActivo'));
    }
}