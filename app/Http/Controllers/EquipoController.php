<?php

namespace App\Http\Controllers;

use App\Models\Equipo;
use Illuminate\Http\Request;

class EquipoController extends Controller
{
    
    public function index()
    {
        $equipos = Equipo::all();
        return view('admin.equipos.index',compact('equipos'));
    }

    public function create()
    {
        return view('admin.equipos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
        ]);

        Equipo::create($request->all());

        return redirect()->route('admin.equipos.index')
            ->with('mensaje', 'equipo creado correctamente')
            ->with('icono', 'success');
    }

    public function show(Equipo $equipo)
    {
        
    }

    public function edit($id)
    {
         $equipo = Equipo::findOrFail($id);
        return view('admin.equipos.edit', compact('equipo'));
    }

    public function update(Request $request,  $id)
    {
        $request->validate([
            'nombre'      => 'required|string|max:255',
        ]);

        $equipo = Equipo::findOrFail($id);
        $equipo->update($request->all());

        return redirect()->route('admin.equipos.index')
            ->with('mensaje', 'equipo actualizado correctamente')
            ->with('icono', 'success');
    }

    public function destroy( $id)
    {
        $equipo = Equipo::findOrFail($id);
        $equipo->delete();

        return redirect()->route('admin.equipos.index')
            ->with('mensaje', 'equipo eliminado correctamente')
            ->with('icono', 'success');
    }
}
