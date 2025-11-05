<?php

namespace App\Http\Controllers;

use App\Models\Administrativo;
use App\Models\Equipo;
use App\Models\Hospital;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Usuario;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
class AdminController extends Controller
{
    public function index(){
               $user = Auth::user();
    if ($user->hasRole(['administrador','tecnico'])) {
        $total_roles = Role::count();
        $total_hospitales=Hospital::count();
        $total_administrativos=Administrativo::count();
        $total_equipos=Equipo::count();
        $total_usuarios=Usuario::count();
    return view(  'admin.index',compact(
                                          'total_roles',
                                          'total_hospitales',
                                          'total_administrativos',
                                          'total_equipos',
                                          'total_usuarios',
                                        
                                          ));    
                                          
    } else {
      return view('admin.indexUsuario');
       }
    }
}

