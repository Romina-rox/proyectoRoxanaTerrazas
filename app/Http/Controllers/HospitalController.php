<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function index()
    {
              $hospitales = Hospital::all();
              return view('admin.hospitales.index', compact('hospitales'));
    }
    public function create()
    {
        return view('admin.hospitales.create');
    }
    public function store(Request $request)
    {
         $request->validate([
            'nombre'      => 'required|string|max:255',
            'tipo'        => 'required',
            'telefono' => 'required|int',
            'direccion' => 'required|string|max:255',
        ]);

        Hospital::create($request->all());

        return redirect()->route('admin.hospitales.index')
            ->with('mensaje', 'Hospital creado correctamente')
            ->with('icono', 'success');
    }
    public function show(Hospital $hospital)
    {
        //
    }
    public function edit($id)
    {
               $hospital = Hospital::find($id);
        return view('admin.hospitales.edit', compact('hospital'));
   
    }
    public function update(Request $request, $id)
    {
         $request->validate([
            'nombre'      => 'required|string|max:255',
            'tipo'        => 'required',
            'telefono' => 'required|int',
            'direccion' => 'required|string|max:255',
        ]);

        $hospital = Hospital::find($id);
        $hospital->update($request->all());

        return redirect()->route('admin.hospitales.index')
            ->with('mensaje', 'Hospital actualizada correctamente')
            ->with('icono', 'success');
    }
    public function destroy($id)
    {
        $hospital = Hospital::find($id);
        $hospital->delete();

        return redirect()->route('admin.hospitales.index')
            ->with('mensaje', 'Hospital eliminada correctamente')
            ->with('icono', 'success');
    }
}
