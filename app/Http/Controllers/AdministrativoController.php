<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
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
      $roles = Role::all(); // Obtén todos los roles de la base de datos
        return view('admin.administrativos.create', compact('roles'));
    }
    public function store(Request $request)
   {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|unique:administrativos',
            'fecha_nacimiento' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'profesion' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users',
        ]);
        // Verificación para limitar a un solo administrador
        if ($request->rol === 'administrador') {
            $adminRole = Role::where('name', 'administrador')->first();
            if ($adminRole && $adminRole->users()->count() > 0) {
                return redirect()->back()->withErrors(['rol' => 'Ya existe un administrador registrado. No se puede crear otro.'])->withInput();
            }
        }
            $usuario = new User();//al poner use se importa
            $usuario->name = $request->nombres . " " . $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->ci);//importamos con hash
     
            $usuario->save();

            $usuario->assignRole($request->rol);

            $administrativo = new Administrativo();
            $administrativo->usuario_id = $usuario->id;
            $administrativo->nombres = $request->nombres;
            $administrativo->apellidos = $request->apellidos;
            $administrativo->ci = $request->ci;
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
        $roles=Role::all();
        $administrativo=Administrativo::find($id);
        return view('admin.administrativos.show', compact('administrativo','roles'));
    }
    public function edit($id)
    {
        $roles=Role::all();
        $administrativo=Administrativo::find($id);
        return view('admin.administrativos.edit', compact('administrativo','roles'));
    }
    public function update(Request $request,  $id)
  {
        $administrativo=Administrativo::find($id);

        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|unique:administrativos,ci, '.$administrativo->id,
            'fecha_nacimiento' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'profesion' => 'required',
            'rol' => 'required|unique:users,email, '.$administrativo->usuario->id,
        ]);
           // Verificación para limitar a un solo administrador
        if ($request->rol === 'administrador') {
            $adminRole = Role::where('name', 'administrador')->first();
            if ($adminRole) {
                $adminUsersCount = $adminRole->users()->where('id', '!=', $administrativo->usuario->id)->count();
                if ($adminUsersCount > 0) {
                    return redirect()->back()->withErrors(['rol' => 'Ya existe otro administrador registrado. No se puede asignar este rol.'])->withInput();
                }
            }
        }

            $usuario = $administrativo->usuario;
            $usuario->name = $request->nombres . " " . $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->ci); 
            $usuario->save();

            $usuario->syncRoles($request->rol);

            $administrativo->usuario_id = $usuario->id;
            $administrativo->nombres = $request->nombres;
            $administrativo->apellidos = $request->apellidos;
            $administrativo->ci = $request->ci;
            $administrativo->fecha_nacimiento = $request->fecha_nacimiento;
            $administrativo->telefono = $request->telefono;
            $administrativo->direccion = $request->direccion;
            $administrativo->profesion = $request->profesion;
            $administrativo->save();

            return redirect()->route('admin.administrativos.index')
                ->with('mensaje', 'Personal actualizado correctamente')
                ->with('icono', 'success');
    }
    public function destroy( $id)
    {
        $administrativo=Administrativo::find($id);
        $administrativo->delete();
        $administrativo->usuario->delete();
        return redirect()->route('admin.administrativos.index')
                ->with('mensaje', 'Personal eliminado correctamente')
                ->with('icono', 'success');
    }
}
