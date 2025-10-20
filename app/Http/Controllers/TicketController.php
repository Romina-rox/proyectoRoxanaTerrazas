<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Usuario;
use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Actualizar alertas para todos los tickets aceptados (para alertas en tiempo real)
        $ticketsAceptados = Ticket::aceptados()->get();
        foreach ($ticketsAceptados as $ticket) {
            $ticket->verificarAlertaTiempo();
        }
        
        // Si es usuario normal, solo ve sus tickets
        if ($user->hasRole('usuario')) {
            $tickets = Ticket::with(['usuario', 'equipo'])
                           ->whereHas('usuario', function($query) use ($user) {
                               $query->where('user_id', $user->id);
                           })
                           ->orderBy('created_at', 'desc')
                           ->get();
        } else {
            // Administrador, técnico y pasante ven todos los tickets
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
        
        // Verificar que el usuario tenga perfil de usuario del sistema
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
        // Validación (mantén tu código actual si es diferente)
        $request->validate([
            'equipo_id' => 'required|exists:equipos,id',
            'numero_activo' => 'required|unique:tickets',
            'descripcion_problema' => 'required|string|max:1000',
            'descripcion_equipo' => 'required|string|max:1000',
            'fecha_ingreso' => 'required|date'
        ]);

        $user = Auth::user();
        $usuario = Usuario::where('user_id', $user->id)->first();

        // Si no tiene perfil, error (pero como ya creaste el perfil, no pasa)
        if (!$usuario) {
            return redirect('/admin/tickets')
                ->with('mensaje', 'Error: No se encontró su perfil de usuario.')
                ->with('icono', 'error');
        }

        // Crear el ticket (mantén tu lógica actual)
        $ticket = Ticket::create([
            'usuario_id' => $usuario->id,
            'equipo_id' => $request->equipo_id,
            'numero_activo' => $request->numero_activo,
            'descripcion_problema' => $request->descripcion_problema,
            'descripcion_equipo' => $request->descripcion_equipo,
            'fecha_ingreso' => $request->fecha_ingreso,
            'estado' => 'en_espera',
        ]);

        // ¡ÉXITO! Redirección con URL directa (SOLUCIONA EL ERROR EN LÍNEA 88)
        return redirect('/admin/tickets')  // En lugar de redirect()->route('admin.tickets.index')
            ->with('mensaje', 'Ticket creado correctamente. Puedes seguirlo desde la lista.')
            ->with('icono', 'success');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Errores de validación: Vuelve al formulario con errores
        return redirect()->back()->withErrors($e->validator)->withInput();
    } catch (\Exception $e) {
        // Otros errores: Loguea y redirige con mensaje
        //Log::error('Error al crear ticket: ' . $e->getMessage());
        return redirect('/admin/tickets')
            ->with('mensaje', 'Error al crear el ticket. Inténtalo de nuevo.')
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
            'numero_activo' => 'required|unique:tickets,numero_activo,' . $id,
            'descripcion_problema' => 'required',
            'descripcion_equipo' => 'required',
            'detalle_salida' => 'nullable',
            'fecha_ingreso' => 'required|date',
            'fecha_salida' => 'nullable|date',
            'estado' => 'required|in:aceptado,en_reparacion,reparado,dado_de_baja'
        ]);

        $estadoAnterior = $ticket->estado;
        // Actualizar datos básicos
        $ticket->equipo_id = $request->equipo_id;
        $ticket->numero_activo = $request->numero_activo;
        $ticket->descripcion_problema = $request->descripcion_problema;
        $ticket->descripcion_equipo = $request->descripcion_equipo;
        $ticket->detalle_salida = $request->detalle_salida;
        $ticket->fecha_ingreso = $request->fecha_ingreso;
        $ticket->fecha_salida = $request->fecha_salida;
        // Si cambió el estado, usar el método del modelo
        if ($estadoAnterior !== $request->estado) {
            $ticket->cambiarEstado($request->estado, $request->detalle_salida);
        } else {
            $ticket->save();
        }

        return redirect('/admin/tickets')  // En lugar de redirect()->route('admin.tickets.index')
            ->with('mensaje', 'Ticket editado correctamente')
            ->with('icono', 'success');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect('/admin/tickets')  // En lugar de redirect()->route('admin.tickets.index')
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
            $ticket->cambiarEstado('aceptado');  // Esto setea estado, fecha_aceptacion y verifica alerta
        return redirect('/admin/tickets')
            ->with('mensaje', 'Ticket aceptado correctamente.')
            ->with('icono', 'success');
        } catch (\Exception $e) {
            //Log::error('Error en aceptarTicket: ' . $e->getMessage());  // Log para debug
            return redirect()->back()->with('mensaje', 'Error al aceptar ticket: ' . $e->getMessage())->with('icono', 'error');
        }
    }


    // Método para marcar como entregado
    public function marcarDevuelto(Request $request, $id)
    {
       try {
            $ticket = Ticket::findOrFail($id);
            if (!in_array($ticket->estado, ['reparado', 'baja'])) {
                return redirect()->back()->with('mensaje', 'Solo se puede devolver tickets reparados o de baja')->with('icono', 'error');
            }
            $ticket->cambiarEstado('devuelto', $request->detalle_devolucion ?? null); // Opcional: detalle adicional
           return redirect('/admin/tickets')
                ->with('mensaje', 'Equipo marcado como devuelto correctamente. Puedes imprimir el comprobante.')
                ->with('icono', 'success');
        } catch (\Exception $e) {
            return redirect()->back()->with('mensaje', 'Error: Ticket no encontrado o error al procesar.')->with('icono', 'error');
        }
    }

    // Método para generar comprobante de entrega
    public function comprobante($id)
    {
        $ticket = Ticket::with(['usuario.hospital', 'equipo'])->findOrFail($id);
        return view('admin.tickets.comprobante', compact('ticket'));
    }

    // Vista para técnicos - tickets pendientes
    public function pendientes()
    {
        try {
            $tickets = Ticket::with(['usuario.hospital', 'equipo'])  // Carga relaciones (verifica que existan en modelos)
                        ->whereIn('estado', ['reparado', 'baja'])  // Solo estados listos para devolución
                        ->where('estado', '!=', 'devuelto')  // Excluye ya entregados (en lugar de 'entregado' booleano)
                        ->orderBy('fecha_salida', 'asc')  // Ordena por fecha salida (más antiguos primero)
                        ->get();

            return view('admin.tickets.pendientes', compact('tickets'));
        } catch (\Exception $e) {
            //\Log::error('Error en pendientes(): ' . $e->getMessage());
            return redirect('/admin/tickets')
                ->with('mensaje', 'Error al cargar tickets pendientes. Inténtalo de nuevo.')
                ->with('icono', 'error');
        }
    }
 public function alertaTiempo()
    {
        // Actualizar alertas para TODOS los tickets aceptados
        $ticketsAceptados = Ticket::where('estado', 'aceptado')->get();
        
        foreach ($ticketsAceptados as $ticket) {
            $ticket->verificarAlertaTiempo();
        }

        // Obtener solo tickets con alerta activa y en estado aceptado
        $tickets = Ticket::with(['usuario.hospital', 'equipo'])
                       ->where('estado', 'aceptado') // IMPORTANTE: Solo aceptados
                       ->where('alerta_tiempo', true)
                       ->orderBy('fecha_aceptacion', 'asc')
                       ->get();
        
        return view('admin.tickets.alerta-tiempo', compact('tickets'));
    }
}