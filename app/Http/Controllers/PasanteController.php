<?php

namespace App\Http\Controllers;

use App\Models\Pasante;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;


class PasanteController extends Controller
{
    public function index()
    {
         $pasantes = Pasante::all();
           return view('admin.pasantes.index', compact('pasantes'));
    }
    public function create()
    {
        $roles=Role::all();
         return view('admin.pasantes.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres' => 'required',
            'apellidos' => 'required',
            'ci' => 'required|unique:pasantes',
            'fecha_nacimiento' => 'required',
            'celular' => 'required',
            'ref_celular' => 'required',
            'parentesco' => 'required',
            'carrera' => 'required',
            'universidad' => 'required',
            'rol' => 'required',
            'email' => 'required|unique:users',
            'foto' => 'nullable|image',
        ]);

    //    DB::beginTransaction();

    //    try {
            $usuario = new User();
            $usuario->name = $request->nombres . " " . $request->apellidos;
            $usuario->email = $request->email;
            $usuario->password = Hash::make($request->ci);
            $usuario->save();

            $usuario->assignRole($request->rol);

            $pasante = new Pasante();
            $pasante->usuario_id = $usuario->id;
            $pasante->nombres = $request->nombres;
            $pasante->apellidos = $request->apellidos;
            $pasante->ci = $request->ci;
            $pasante->fecha_nacimiento = $request->fecha_nacimiento;
            $pasante->celular = $request->celular;
            $pasante->ref_celular = $request->ref_celular;
            $pasante->parentesco = $request->parentesco;
            $pasante->carrera = $request->carrera;
            $pasante->email = $request->email;
            $pasante->universidad = $request->universidad;

            if ($request->hasFile('foto')) {
                $foto = $request->file('foto');
                $nombreArchivo = time() . '_' . $foto->getClientOriginalName();
                $rutaDestino = public_path('upload/fotos_pasantes');
                $foto->move($rutaDestino, $nombreArchivo);
                $pasante->foto = 'upload/fotos_pasantes/' . $nombreArchivo;
            } else {
                $pasante->foto = '';
            }

            $pasante->estado = 'activo';
            $pasante->save();

        //    DB::commit();

            return redirect()->route('admin.pasantes.index')
                ->with('message', 'Técnico registrado correctamente')
                ->with('icono', 'success');

       // } catch (\Exception $e) {
       //     DB::rollBack();
       //     return back()->withErrors(['error' => 'Ocurrió un error: '.$e->getMessage()]);
       // }
    }

    public function show( $id)
    {
            $roles=Role::all();
        $pasante=Pasante::find($id);
        return view('admin.pasantes.show', compact('pasante','roles'));
    }
    public function edit( $id)
    {
        $pasante=Pasante::find($id);
          $roles=Role::all();
        return view('admin.pasantes.edit', compact('pasante','roles'));
    }
    public function update(Request $request, $id)
    {
       // $datos=request()->all();
      //  return response()->json($datos);
        $pasante=Pasante::find($id);
        $request->validate([
        'nombres' => 'required',
        'apellidos' => 'required',
        'ci' => 'required|unique:pasantes,ci,'.$id,
        'fecha_nacimiento' => 'required',
        'celular' => 'required',
        'ref_celular' => 'required',
        'parentesco' => 'required',
        'carrera' => 'required',
        'universidad' => 'required',
        'rol' => 'required',
      //  'email' => 'required|unique:users',
        'foto' => 'nullable|image'
        ]);
    $usuario = User::find($pasante->usuario->id);
    $usuario->name = $request->nombres . " " . $request->apellidos;
    $usuario->email = $request->email;
    $usuario->password = Hash::make($request->ci);//para que su contraseña sea el ci yesss
    $usuario->save();

    $usuario->syncRoles($request->rol);
    
        $pasante->usuario_id = $usuario->id;
        $pasante->nombres = $request->nombres;
        $pasante->apellidos = $request->apellidos;
        $pasante->ci = $request->ci;
        $pasante->fecha_nacimiento = $request->fecha_nacimiento;
        $pasante->celular = $request->celular;
        $pasante->ref_celular = $request->ref_celular;
        $pasante->parentesco = $request->parentesco;
        $pasante->carrera = $request->carrera;
       // $pasante->email = $request->email;
        $pasante->universidad = $request->universidad;


        if ($request->hasFile('foto')) {
            $foto = $request->file('foto');
            $nombreArchivo = time() . '_' . $foto->getClientOriginalName();
            $rutaDestino = public_path('upload/fotos_pasantes');
            $foto->move($rutaDestino, $nombreArchivo);
            $pasante->foto = 'upload/fotos_pasantes/' . $nombreArchivo;
        } else {
            $pasante->foto = ''; // o puedes dejarla vacía
        }

        $pasante->estado = 'activo';
        $pasante->save();

        return redirect()->route('admin.pasantes.index')
            ->with('message', 'pasante actualizo correctamente')
            ->with('icono', 'success');
    }

    public function destroy( $id)
    {
       $pasante=Pasante::find($id);
       $usuario=User::find($pasante->usuario_id);

       if($pasante->foto && file_exists(public_path($pasante->foto))){
            unlink(public_path($pasante->foto));
       }
        $pasante->usuario->delete();
        return redirect()->route('admin.pasantes.index')
                ->with('mensaje', 'Personal eliminado correctamente')
                ->with('icono', 'success');             
    }
}
