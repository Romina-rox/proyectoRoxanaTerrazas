<?php

use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
*/

Route::get('/', function () {
    return redirect('/admin');
});

Auth::routes();

//Route::get('/register', function () {
//    abort(403, 'Registro no permitido'); // O redirigir a otra ruta----------------NO ME PERMITE CREAR OTROS USUARIOS EXTERNOS
//})->name('register');

Route::get('/home', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index.home')->middleware('auth');

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index')->middleware('auth');

//rutas para roles
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth','can:admin.roles.index');
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth','can:admin.roles.create');
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth','can:admin.roles.store');
Route::get('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'permisos'])->name('admin.roles.permisos')->middleware('auth','can:admin.roles.permisos');
Route::post('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update_permisos'])->name('admin.roles.update_permisos')->middleware('auth','can:admin.roles.update_permisos');
Route::get('/admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth','can:admin.roles.edit');
Route::put('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth','can:admin.roles.update');
Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth','can:admin.roles');

//rutas para administrador
Route::get('/admin/administrativos', [App\Http\Controllers\AdministrativoController::class, 'index'])->name('admin.administrativos.index')->middleware('auth','can:admin.administrativos.index');
Route::get('/admin/administrativos/create', [App\Http\Controllers\AdministrativoController::class, 'create'])->name('admin.administrativos.create')->middleware('auth','can:admin.administrativos.create');
Route::post('/admin/administrativos/create', [App\Http\Controllers\AdministrativoController::class, 'store'])->name('admin.administrativos.store')->middleware('auth','can:admin.administrativos.store');
Route::get('/admin/administrativos/{id}', [App\Http\Controllers\AdministrativoController::class, 'show'])->name('admin.administrativos.show')->middleware('auth','can:admin.administrativos.show');
Route::get('/admin/administrativos/{id}/edit', [App\Http\Controllers\AdministrativoController::class, 'edit'])->name('admin.administrativos.edit')->middleware('auth','can:admin.administrativos.edit');;
Route::put('/admin/administrativos/{id}', [App\Http\Controllers\AdministrativoController::class, 'update'])->name('admin.administrativos.update')->middleware('auth','can:admin.administrativos.update');
Route::delete('/admin/administrativos/{id}', [App\Http\Controllers\AdministrativoController::class, 'destroy'])->name('admin.administrativos.destroy')->middleware('auth','can:admin.administrativos.destroy');

//rutas para hospitales 
Route::get('/admin/hospitales', [App\Http\Controllers\HospitalController::class, 'index'])->name('admin.hospitales.index')->middleware('auth','can:admin.hospitales.index');
Route::get('/admin/hospitales/create', [App\Http\Controllers\HospitalController::class, 'create'])->name('admin.hospitales.create')->middleware('auth','can:admin.hospitales.create');
Route::post('/admin/hospitales/create', [App\Http\Controllers\HospitalController::class, 'store'])->name('admin.hospitales.store')->middleware('auth','can:admin.hospitales.store');
Route::get('/admin/hospitales/{id}/edit', [App\Http\Controllers\HospitalController::class, 'edit'])->name('admin.hospitales.edit')->middleware('auth','can:admin.hospitales.edit');
Route::put('/admin/hospitales/{id}', [App\Http\Controllers\HospitalController::class, 'update'])->name('admin.hospitales.update')->middleware('auth','can:admin.hospitales.update');
Route::delete('/admin/hospitales/{id}', [App\Http\Controllers\HospitalController::class, 'destroy'])->name('admin.hospitales.destroy')->middleware('auth','can:admin.hospitales.destroy');

//rutas para EQUIPOS
Route::get('/admin/equipos', [App\Http\Controllers\EquipoController::class, 'index'])->name('admin.equipos.index')->middleware('auth','can:admin.equipos.index');
Route::get('/admin/equipos/create', [App\Http\Controllers\EquipoController::class, 'create'])->name('admin.equipos.create')->middleware('auth','can:admin.equipos.create');
Route::post('/admin/equipos/create', [App\Http\Controllers\EquipoController::class, 'store'])->name('admin.equipos.store')->middleware('auth','can:admin.equipos.store');
//Route::get('/admin/equipos/{id}', [App\Http\Controllers\EquipoController::class, 'show'])->name('admin.equipos.show')->middleware('auth');
Route::get('/admin/equipos/{id}/edit', [App\Http\Controllers\EquipoController::class, 'edit'])->name('admin.equipos.edit')->middleware('auth','can:admin.equipos.edit');
Route::put('/admin/equipos/{id}', [App\Http\Controllers\EquipoController::class, 'update'])->name('admin.equipos.update')->middleware('auth','can:admin.equipos.update');
Route::delete('/admin/equipos/{id}', [App\Http\Controllers\EquipoController::class, 'destroy'])->name('admin.equipos.destroy')->middleware('auth','can:admin.equipos.destroy');

//rutas para tecnicos
Route::get('/admin/tecnicos', [App\Http\Controllers\TecnicoController::class, 'index'])->name('admin.tecnicos.index')->middleware('auth','can:admin.tecnicos.index');
Route::get('/admin/tecnicos/create', [App\Http\Controllers\TecnicoController::class, 'create'])->name('admin.tecnicos.create')->middleware('auth','can:admin.tecnicos.create');
Route::post('/admin/tecnicos/create', [App\Http\Controllers\TecnicoController::class, 'store'])->name('admin.tecnicos.store')->middleware('auth','can:admin.tecnicos.store');
Route::get('/admin/tecnicos/{id}', [App\Http\Controllers\TecnicoController::class, 'show'])->name('admin.tecnicos.show')->middleware('auth','can:admin.tecnicos.show');
Route::get('/admin/tecnicos/{id}/edit', [App\Http\Controllers\TecnicoController::class, 'edit'])->name('admin.tecnicos.edit')->middleware('auth','can:admin.tecnicos.edit');
Route::put('/admin/tecnicos/{id}', [App\Http\Controllers\TecnicoController::class, 'update'])->name('admin.tecnicos.update')->middleware('auth','can:admin.tecnicos.update');
Route::delete('/admin/tecnicos/{id}', [App\Http\Controllers\TecnicoController::class, 'destroy'])->name('admin.tecnicos.destroy')->middleware('auth','can:admin.tecnicos.destroy');

//rutas para pasantes
Route::get('/admin/pasantes', [App\Http\Controllers\PasanteController::class, 'index'])->name('admin.pasantes.index')->middleware('auth','can:admin.pasantes.index');
Route::get('/admin/pasantes/create', [App\Http\Controllers\PasanteController::class, 'create'])->name('admin.pasantes.create')->middleware('auth','can:admin.pasantes.create');
Route::post('/admin/pasantes/create', [App\Http\Controllers\PasanteController::class, 'store'])->name('admin.pasantes.store')->middleware('auth','can:admin.pasantes.store');
Route::get('/admin/pasantes/{id}', [App\Http\Controllers\PasanteController::class, 'show'])->name('admin.pasantes.show')->middleware('auth','can:admin.pasantes.show');
Route::get('/admin/pasantes/{id}/edit', [App\Http\Controllers\PasanteController::class, 'edit'])->name('admin.pasantes.edit')->middleware('auth','can:admin.pasantes.edit');
Route::put('/admin/pasantes/{id}', [App\Http\Controllers\PasanteController::class, 'update'])->name('admin.pasantes.update')->middleware('auth','can:admin.pasantes.update');
Route::delete('/admin/pasantes/{id}', [App\Http\Controllers\PasanteController::class, 'destroy'])->name('admin.pasantes.destroy')->middleware('auth','can:admin.pasantes.destroy');

//rutas para usuarios
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth','can:admin.usuarios.index');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth','can:admin.usuarios.create');
Route::post('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth','can:admin.usuarios.store');
Route::get('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth','can:admin.usuarios.show');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth','can:admin.usuarios.edit');
Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth','can:admin.usuarios.update');
Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth','can:admin.usuarios.destroy');


// Rutas para el módulo de tickets (agregar esto al archivo web.php)
Route::middleware(['auth'])->prefix('admin')->group(function () {
    // Rutas principales de tickets
    Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('admin.tickets.create');
    Route::post('/tickets/create', [TicketController::class, 'store'])->name('admin.tickets.store');
    Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('admin.tickets.show');
    Route::get('/tickets/{id}/edit', [TicketController::class, 'edit'])->name('admin.tickets.edit');
    Route::put('/tickets/{id}', [TicketController::class, 'update'])->name('admin.tickets.update');
    Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('admin.tickets.destroy');
    
    // Rutas especiales (DEBEN IR ANTES de Resource para evitar conflictos)
    Route::get('/tickets/{id}/aceptar', [TicketController::class, 'aceptarTicket'])->name('tickets.aceptar');
    Route::post('/tickets/{id}/devuelto', [TicketController::class, 'marcarDevuelto'])->name('tickets.devuelto');
    Route::get('/tickets/{id}/comprobante', [TicketController::class, 'comprobante'])->name('tickets.comprobante');
    Route::get('/tickets/{id}/descargar-word', [TicketController::class, 'descargarWord'])->name('tickets.descargarWord');
    Route::get('/tickets-pendientes', [TicketController::class, 'pendientes'])->name('tickets.pendientes');
    Route::get('/tickets-alerta-tiempo', [TicketController::class, 'alertaTiempo'])->name('tickets.alertaTiempo');
    Route::get('/tickets-dashboard', [TicketController::class, 'dashboard'])->name('tickets.dashboard');
    // Ruta Resource genérica (CRUD básico)
    Route::resource('tickets', TicketController::class)->names('tickets');
});