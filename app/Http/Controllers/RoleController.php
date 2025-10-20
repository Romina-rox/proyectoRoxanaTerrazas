<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
         $roles = Role::all();
        return view('admin.roles.index', compact('roles'));
    }
    public function create()
    {
         return view('admin.roles.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name'      => 'required|unique:roles',
        ]);

        $rol = new Role();
        $rol ->name =$request->name;
        $rol -> save();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'rol creado correctamente')
            ->with('icono', 'success');
    }
    public function show(string $id)
    {
    }
    public function permisos(string $id)
    {
        $rol = Role::find($id);
        $permisos =Permission::all()->groupBy(function ($permiso){
            if(stripos($permiso->name,'hospitales')!== false){ return 'hospitales'; }
            if(stripos($permiso->name,'equipos')!== false){  return 'equipos';}
            if(stripos($permiso->name,'administrativos')!== false){ return 'administrativos'; }
            if(stripos($permiso->name,'roles')!== false){ return 'roles'; }
            if(stripos($permiso->name,'pasantes')!== false){ return 'pasantes'; }
            if(stripos($permiso->name,'tecnicos')!== false){  return 'tecnicos'; }
            if(stripos($permiso->name,'usuarios')!== false){ return 'usuarios'; }
            if(stripos($permiso->name,'tickets')!== false){  return 'tickets'; }
        });
        return view('admin.roles.permisos',compact('permisos','rol'));
    }
    public function update_permisos(Request $request, $id){
        $rol=Role::find($id);
        $rol->permissions()->sync($request->input('permisos'));

       return redirect()->route('admin.roles.index')
            ->with('mensaje', 'se modificaron permisos correctamente')
            ->with('icono', 'success');
    }
    public function edit(string $id)
    {
          $role = Role::find($id);
        return view('admin.roles.edit', compact('role'));
    }
    public function update(Request $request, string $id)
    {
         $request->validate([
            'name'      => 'required|unique:roles,name,' .$id,
        ]);

        $rol = Role::find($id);//busca la ruta
        $rol->name =$request->name;
        $rol->save();

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'rol actualizado correctamente')
            ->with('icono', 'success');
    }
    public function destroy(string $id)
    {
        Role::destroy($id);//recibimos el id y lo destuimos

        return redirect()->route('admin.roles.index')
            ->with('mensaje', 'rol eliminado correctamente')
            ->with('icono', 'success');
    }
}
