<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use App\Models\User;
use App\Models\Hospital;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::with(['user', 'hospital'])->get();
        return view('admin.usuarios.index', compact('usuarios'));
    }  
    
    public function create()
    {
        $roles = Role::all();
        $hospitales = Hospital::all();
        return view('admin.usuarios.create', compact('hospitales','roles'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|unique:usuarios', // ✅ SIN 'numeric' - acepta letras y números
            'rol' => 'required',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|numeric',
            'direccion' => 'required',
            'cargo' => 'required',
            'hospital_id' => 'required|exists:hospitals,id',
            'email' => 'required|email|unique:users',
            'especialidad' => 'nullable'
        ]);

        // Crear usuario del sistema
        $user = new User();
        $user->name = $request->nombres . " " . $request->apellidos;
        $user->email = $request->email;
        $user->password = Hash::make($request->ci);
        $user->save();

        $user->assignRole($request->rol);
        
        $rolUsuario = Role::where('name', 'usuario')->first();
        if ($rolUsuario) {
            $user->assignRole($rolUsuario);
        }

        // El mutador cifra automáticamente
        $usuario = new Usuario();
        $usuario->user_id = $user->id;
        $usuario->hospital_id = $request->hospital_id;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->ci = $request->ci; // ✅ El mutador lo cifra automáticamente
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->cargo = $request->cargo;
        $usuario->especialidad = $request->especialidad;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario registrado correctamente')
            ->with('icono', 'success');
    }
    
    public function show($id)
    {
        $usuario = Usuario::with(['user', 'hospital'])->findOrFail($id);
        $hospitales = Hospital::all();
        $roles = Role::all();
        return view('admin.usuarios.show', compact('usuario', 'hospitales','roles'));
    }
    
    public function edit($id)
    {
        $usuario = Usuario::with(['user', 'hospital'])->findOrFail($id);
        $hospitales = Hospital::all();
        $roles = Role::all();
        return view('admin.usuarios.edit', compact('usuario', 'hospitales','roles'));
    }
    
    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required', // ✅ SIN 'numeric' - acepta letras y números
            'fecha_nacimiento' => 'required',
            'telefono' => 'required|numeric',
            'direccion' => 'required',
            'cargo' => 'required',
            'rol' => 'required',
            'hospital_id' => 'required|exists:hospitals,id',
            'email' => 'required|email|unique:users,email,' . $usuario->user->id,
            'especialidad' => 'nullable'
        ]);

        // Actualizar usuario del sistema
        $user = $usuario->user;
        $user->name = $request->nombres . " " . $request->apellidos;
        $user->email = $request->email;
        $user->password = Hash::make($request->ci);
        $user->save();

        $user->syncRoles($request->rol);
        
        // El mutador cifra automáticamente
        $usuario->hospital_id = $request->hospital_id;
        $usuario->nombres = $request->nombres;
        $usuario->apellidos = $request->apellidos;
        $usuario->ci = $request->ci; // ✅ El mutador lo cifra automáticamente
        $usuario->fecha_nacimiento = $request->fecha_nacimiento;
        $usuario->telefono = $request->telefono;
        $usuario->direccion = $request->direccion;
        $usuario->cargo = $request->cargo;
        $usuario->especialidad = $request->especialidad;
        $usuario->save();

        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario actualizado correctamente')
            ->with('icono', 'success');
    }
    
    public function destroy($id)
    {
        $usuario = Usuario::findOrFail($id);
        $usuario->user->delete();
        
        return redirect()->route('admin.usuarios.index')
            ->with('mensaje', 'Usuario eliminado correctamente')
            ->with('icono', 'success');
    }
}