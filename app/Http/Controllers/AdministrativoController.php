<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Role;

class AdministrativoController extends Controller
{
    public function index()
    {
        $administrativos = Administrativo::all();
        return view('admin.administrativos.index', compact('administrativos'));
    }
    
    public function create()
    {
        $roles = Role::all();
        return view('admin.administrativos.create', compact('roles'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|unique:administrativos',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|numeric', // <--- SOLUCIÓN APLICADA
            'direccion' => 'required',
            'profesion' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users',
        ]);
        
        // Verificación para limitar a un solo administrador
        if ($request->rol === 'administrador') {
            $adminRole = Role::where('name', 'administrador')->first();
            if ($adminRole && $adminRole->users()->count() > 0) {
                return redirect()->back()
                    ->withErrors(['rol' => 'Ya existe un administrador registrado. No se puede crear otro.'])
                    ->withInput();
            }
        }
        
        // Crear usuario del sistema
        $usuario = new User();
        $usuario->name = $request->nombres . " " . $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->ci); // CI como contraseña hasheada
        $usuario->save();

        $usuario->assignRole($request->rol);

        // Crear administrativo con CI CIFRADO
        $administrativo = new Administrativo();
        $administrativo->usuario_id = $usuario->id;
        $administrativo->nombres = $request->nombres;
        $administrativo->apellidos = $request->apellidos;
        $administrativo->ci = $request->ci; // ⭐ El mutator lo cifrará automáticamente
        $administrativo->fecha_nacimiento = $request->fecha_nacimiento;
        $administrativo->telefono = $request->telefono;
        $administrativo->direccion = $request->direccion;
        $administrativo->profesion = $request->profesion;
        $administrativo->save();

        return redirect()->route('admin.administrativos.index')
            ->with('mensaje', 'Personal registrado correctamente')
            ->with('icono', 'success');
    }

    public function show($id)
    {
        $roles = Role::all();
        $administrativo = Administrativo::findOrFail($id);
        return view('admin.administrativos.show', compact('administrativo','roles'));
    }
    
    public function edit($id)
    {
        $roles = Role::all();
        $administrativo = Administrativo::findOrFail($id);
        return view('admin.administrativos.edit', compact('administrativo','roles'));
    }
    
    public function update(Request $request, $id)
    {
        $administrativo = Administrativo::findOrFail($id);

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|numeric', // <--- SOLUCIÓN APLICADA
            'direccion' => 'required',
            'profesion' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users,email,'.$administrativo->usuario->id,
        ]);
        
        // Verificación para limitar a un solo administrador
        if ($request->rol === 'administrador') {
            $adminRole = Role::where('name', 'administrador')->first();
            if ($adminRole) {
                $adminUsersCount = $adminRole->users()
                    ->where('id', '!=', $administrativo->usuario->id)
                    ->count();
                if ($adminUsersCount > 0) {
                    return redirect()->back()
                        ->withErrors(['rol' => 'Ya existe otro administrador registrado. No se puede asignar este rol.'])
                        ->withInput();
                }
            }
        }

        // Actualizar usuario del sistema
        $usuario = $administrativo->usuario;
        $usuario->name = $request->nombres . " " . $request->apellidos;
        $usuario->email = $request->email;
        $usuario->password = Hash::make($request->ci); // Actualizar contraseña
        $usuario->save();

        $usuario->syncRoles($request->rol);

        // Actualizar administrativo con CI CIFRADO
        $administrativo->usuario_id = $usuario->id;
        $administrativo->nombres = $request->nombres;
        $administrativo->apellidos = $request->apellidos;
        $administrativo->ci = $request->ci; // ⭐ El mutator lo cifrará automáticamente
        $administrativo->fecha_nacimiento = $request->fecha_nacimiento;
        $administrativo->telefono = $request->telefono;
        $administrativo->direccion = $request->direccion;
        $administrativo->profesion = $request->profesion;
        $administrativo->save();

        return redirect()->route('admin.administrativos.index')
            ->with('mensaje', 'Personal actualizado correctamente')
            ->with('icono', 'success');
    }
    
    public function destroy($id)
    {
        $administrativo = Administrativo::findOrFail($id);
        $administrativo->usuario->delete(); // Eliminará el administrativo por cascade
        
        return redirect()->route('admin.administrativos.index')
            ->with('mensaje', 'Personal eliminado correctamente')
            ->with('icono', 'success');
    }
}