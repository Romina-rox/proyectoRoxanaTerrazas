<?php

namespace App\Http\Controllers;

use App\Models\Tecnico;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class TecnicoController extends Controller
{
    public function index()
    {
         $tecnicos = Tecnico::all();
           return view('admin.tecnicos.index', compact('tecnicos'));
    }
    public function create()
    {
        $roles=Role::all();
         return view('admin.tecnicos.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|unique:tecnicos',
            'fecha_nacimiento' => 'required',
            'celular' => 'required',
            'ref_celular' => 'required',
            'parentesco' => 'required',
            'direccion' => 'required',
            'profesion' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users',
            'foto' => 'nullable|image',
        ]);

        DB::beginTransaction();

        try {
            $usuario = new User();
            $usuario->name = $request->nombres . " " . $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->ci);
            $usuario->save();

            $usuario->assignRole($request->rol);

            $tecnico = new Tecnico();
            $tecnico->usuario_id = $usuario->id;
            $tecnico->nombres = $request->nombres;
            $tecnico->apellidos = $request->apellidos;
            $tecnico->ci = $request->ci;
            $tecnico->fecha_nacimiento = $request->fecha_nacimiento;
            $tecnico->celular = $request->celular;
            $tecnico->ref_celular = $request->ref_celular;
            $tecnico->parentesco = $request->parentesco;
            $tecnico->direccion = $request->direccion;
            $tecnico->email = $request->email;
            $tecnico->profesion = $request->profesion;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nombreArchivo = time() . '_' . $foto->getClientOriginalName();
                $rutaDestino = public_path('upload/fotos_tecnicos');
                $foto->move($rutaDestino, $nombreArchivo);
                $tecnico->foto = 'upload/fotos_tecnicos/' . $nombreArchivo;
            } else {
                $tecnico->foto = '';
            }

            $tecnico->estado = 'activo';
            $tecnico->save();

            DB::commit();

            return redirect()->route('admin.tecnicos.index')
                ->with('message', 'Técnico registrado correctamente')
                ->with('icono', 'success');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Ocurrió un error: '.$e->getMessage()]);
        }
    }

    public function show( $id)
    {
            $roles=Role::all();
        $tecnico=Tecnico::find($id);
        return view('admin.tecnicos.show', compact('tecnico','roles'));
    }
    public function edit( $id)
    {
        $tecnico=Tecnico::find($id);
          $roles=Role::all();
        return view('admin.tecnicos.edit', compact('tecnico','roles'));
    }
    public function update(Request $request, $id)
    {
       // $datos=request()->all();
      //  return response()->json($datos);
        $tecnico=Tecnico::find($id);
        $request->validate([
        'nombres' => 'required',
        'apellidos' => 'required',
        'ci' => 'required|unique:tecnicos,ci,'.$id,
        'fecha_nacimiento' => 'required',
        'celular' => 'required',
        'ref_celular' => 'required',
        'parentesco' => 'required',
        'direccion' => 'required',
        'profesion' => 'required',
        'rol' => 'required',
      //  'email' => 'required|unique:users',
        'foto' => 'nullable|image'
        ]);
    $usuario = User::find($tecnico->usuario->id);
    $usuario->name = $request->nombres . " " . $request->apellidos;
    $usuario->email = $request->email;
    $usuario->password = Hash::make($request->ci);//para que su contraseña sea el ci yesss
    $usuario->save();

    $usuario->syncRoles($request->rol);
    
        $tecnico->usuario_id = $usuario->id;
        $tecnico->nombres = $request->nombres;
        $tecnico->apellidos = $request->apellidos;
        $tecnico->ci = $request->ci;
        $tecnico->fecha_nacimiento = $request->fecha_nacimiento;
        $tecnico->celular = $request->celular;
        $tecnico->ref_celular = $request->ref_celular;
        $tecnico->parentesco = $request->parentesco;
        $tecnico->direccion = $request->direccion;
       // $tecnico->email = $request->email;
        $tecnico->profesion = $request->profesion;


        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreArchivo = time() . '_' . $foto->getClientOriginalName();
            $rutaDestino = public_path('upload/fotos_tecnicos');
            $foto->move($rutaDestino, $nombreArchivo);
            $tecnico->foto = 'upload/fotos_tecnicos/' . $nombreArchivo;
        } else {
            $tecnico->foto = ''; // o puedes dejarla vacía
        }

        $tecnico->estado = 'activo';
        $tecnico->save();

        return redirect()->route('admin.tecnicos.index')
            ->with('message', 'tecnico actualizo correctamente')
            ->with('icono', 'success');
    }

    public function destroy( $id)
    {
       $tecnico=Tecnico::find($id);
       $usuario=User::find($tecnico->usuario_id);

       if($tecnico->foto && file_exists(public_path($tecnico->foto))){
            unlink(public_path($tecnico->foto));
       }
        $tecnico->usuario->delete();
        return redirect()->route('admin.tecnicos.index')
                ->with('mensaje', 'Personal eliminado correctamente')
                ->with('icono', 'success');             
    }
}
