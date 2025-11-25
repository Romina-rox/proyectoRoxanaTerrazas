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
// ============================================
// RUTAS DEL MÓDULO DE ROLES
// ============================================
Route::get('/admin/roles', [App\Http\Controllers\RoleController::class, 'index'])->name('admin.roles.index')->middleware('auth','can:admin.roles.index');
Route::get('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'create'])->name('admin.roles.create')->middleware('auth','can:admin.roles.create');
Route::post('/admin/roles/create', [App\Http\Controllers\RoleController::class, 'store'])->name('admin.roles.store')->middleware('auth','can:admin.roles.store');
Route::get('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'permisos'])->name('admin.roles.permisos')->middleware('auth','can:admin.roles.permisos');
Route::post('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update_permisos'])->name('admin.roles.update_permisos')->middleware('auth','can:admin.roles.update_permisos');
Route::get('/admin/roles/{id}/edit', [App\Http\Controllers\RoleController::class, 'edit'])->name('admin.roles.edit')->middleware('auth','can:admin.roles.edit');
Route::put('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('admin.roles.update')->middleware('auth','can:admin.roles.update');
Route::delete('/admin/roles/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('admin.roles.destroy')->middleware('auth','can:admin.roles.destroy');
// ============================================
// RUTAS DEL MÓDULO DE ADMINISTRATIVOS
// ============================================
Route::get('/admin/administrativos', [App\Http\Controllers\AdministrativoController::class, 'index'])->name('admin.administrativos.index')->middleware('auth','can:admin.administrativos.index');
Route::get('/admin/administrativos/create', [App\Http\Controllers\AdministrativoController::class, 'create'])->name('admin.administrativos.create')->middleware('auth','can:admin.administrativos.create');
Route::post('/admin/administrativos/create', [App\Http\Controllers\AdministrativoController::class, 'store'])->name('admin.administrativos.store')->middleware('auth','can:admin.administrativos.store');
Route::get('/admin/administrativos/{id}', [App\Http\Controllers\AdministrativoController::class, 'show'])->name('admin.administrativos.show')->middleware('auth','can:admin.administrativos.show');
Route::get('/admin/administrativos/{id}/edit', [App\Http\Controllers\AdministrativoController::class, 'edit'])->name('admin.administrativos.edit')->middleware('auth','can:admin.administrativos.edit');;
Route::put('/admin/administrativos/{id}', [App\Http\Controllers\AdministrativoController::class, 'update'])->name('admin.administrativos.update')->middleware('auth','can:admin.administrativos.update');
Route::delete('/admin/administrativos/{id}', [App\Http\Controllers\AdministrativoController::class, 'destroy'])->name('admin.administrativos.destroy')->middleware('auth','can:admin.administrativos.destroy');
// ============================================
// RUTAS DEL MÓDULO DE HOSPITALES
// ============================================
Route::get('/admin/hospitales', [App\Http\Controllers\HospitalController::class, 'index'])->name('admin.hospitales.index')->middleware('auth','can:admin.hospitales.index');
Route::get('/admin/hospitales/create', [App\Http\Controllers\HospitalController::class, 'create'])->name('admin.hospitales.create')->middleware('auth','can:admin.hospitales.create');
Route::post('/admin/hospitales/create', [App\Http\Controllers\HospitalController::class, 'store'])->name('admin.hospitales.store')->middleware('auth','can:admin.hospitales.store');
Route::get('/admin/hospitales/{id}/edit', [App\Http\Controllers\HospitalController::class, 'edit'])->name('admin.hospitales.edit')->middleware('auth','can:admin.hospitales.edit');
Route::put('/admin/hospitales/{id}', [App\Http\Controllers\HospitalController::class, 'update'])->name('admin.hospitales.update')->middleware('auth','can:admin.hospitales.update');
Route::delete('/admin/hospitales/{id}', [App\Http\Controllers\HospitalController::class, 'destroy'])->name('admin.hospitales.destroy')->middleware('auth','can:admin.hospitales.destroy');
// ============================================
// RUTAS DEL MÓDULO DE TIPO DE EQUIPOS
// ============================================
Route::get('/admin/equipos', [App\Http\Controllers\EquipoController::class, 'index'])->name('admin.equipos.index')->middleware('auth','can:admin.equipos.index');
Route::get('/admin/equipos/create', [App\Http\Controllers\EquipoController::class, 'create'])->name('admin.equipos.create')->middleware('auth','can:admin.equipos.create');
Route::post('/admin/equipos/create', [App\Http\Controllers\EquipoController::class, 'store'])->name('admin.equipos.store')->middleware('auth','can:admin.equipos.store');
//Route::get('/admin/equipos/{id}', [App\Http\Controllers\EquipoController::class, 'show'])->name('admin.equipos.show')->middleware('auth');
Route::get('/admin/equipos/{id}/edit', [App\Http\Controllers\EquipoController::class, 'edit'])->name('admin.equipos.edit')->middleware('auth','can:admin.equipos.edit');
Route::put('/admin/equipos/{id}', [App\Http\Controllers\EquipoController::class, 'update'])->name('admin.equipos.update')->middleware('auth','can:admin.equipos.update');
Route::delete('/admin/equipos/{id}', [App\Http\Controllers\EquipoController::class, 'destroy'])->name('admin.equipos.destroy')->middleware('auth','can:admin.equipos.destroy');
// ============================================
// RUTAS DEL MÓDULO DE USUARIOS
// ============================================
Route::get('/admin/usuarios', [App\Http\Controllers\UsuarioController::class, 'index'])->name('admin.usuarios.index')->middleware('auth','can:admin.usuarios.index');
Route::get('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'create'])->name('admin.usuarios.create')->middleware('auth','can:admin.usuarios.create');
Route::post('/admin/usuarios/create', [App\Http\Controllers\UsuarioController::class, 'store'])->name('admin.usuarios.store')->middleware('auth','can:admin.usuarios.store');
Route::get('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'show'])->name('admin.usuarios.show')->middleware('auth','can:admin.usuarios.show');
Route::get('/admin/usuarios/{id}/edit', [App\Http\Controllers\UsuarioController::class, 'edit'])->name('admin.usuarios.edit')->middleware('auth','can:admin.usuarios.edit');
Route::put('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'update'])->name('admin.usuarios.update')->middleware('auth','can:admin.usuarios.update');
Route::delete('/admin/usuarios/{id}', [App\Http\Controllers\UsuarioController::class, 'destroy'])->name('admin.usuarios.destroy')->middleware('auth','can:admin.usuarios.destroy');
// ============================================
// RUTAS DEL MODULO TICKETS 
// ============================================
Route::get('/admin/tickets', [App\Http\Controllers\TicketController::class, 'index'])->name('admin.tickets.index')->middleware('auth','can:admin.tickets.index');
Route::get('/admin/tickets/create', [App\Http\Controllers\TicketController::class, 'create'])->name('admin.tickets.create')->middleware('auth','can:admin.tickets.create');
Route::post('/admin/tickets/create', [App\Http\Controllers\TicketController::class, 'store'])->name('admin.tickets.store')->middleware('auth','can:admin.tickets.store');
Route::get('/admin/tickets/{id}', [App\Http\Controllers\TicketController::class, 'show'])->name('admin.tickets.show')->middleware('auth','can:admin.tickets.show');
Route::get('/admin/tickets/{id}/edit', [App\Http\Controllers\TicketController::class, 'edit'])->name('admin.tickets.edit')->middleware('auth','can:admin.tickets.edit');
Route::put('/admin/tickets/{id}', [App\Http\Controllers\TicketController::class, 'update'])->name('admin.tickets.update')->middleware('auth','can:admin.tickets.update');
Route::delete('/admin/tickets/{id}', [App\Http\Controllers\TicketController::class, 'destroy'])->name('admin.tickets.destroy')->middleware('auth','can:admin.tickets.destroy');
// ACCIONES ESPECIALES
Route::get('/admin/tickets/{id}/aceptar', [App\Http\Controllers\TicketController::class, 'aceptarTicket'])->name('tickets.aceptar')->middleware('auth','can:tickets.aceptar');
Route::post('/admin/tickets/{id}/devuelto-usuario', [App\Http\Controllers\TicketController::class, 'marcarDevueltoUsuario'])->name('tickets.devuelto.usuario')->middleware('auth','can:tickets.devuelto.usuario');
Route::post('/admin/tickets/{id}/entregado-activos-fijos', [App\Http\Controllers\TicketController::class, 'marcarEntregadoActivosFijos'])->name('tickets.entregado.activos.fijos')->middleware('auth','can:tickets.entregado.activos.fijos');
Route::get('/admin/tickets/{id}/comprobante-usuario', [App\Http\Controllers\TicketController::class, 'comprobanteUsuario'])->name('tickets.comprobante.usuario')->middleware('auth','can:tickets.comprobante.usuario');
Route::get('/admin/tickets/{id}/comprobante-activos-fijos', [App\Http\Controllers\TicketController::class, 'comprobanteActivosFijos'])->name('tickets.comprobante.activos.fijos')->middleware('auth','can:tickets.comprobante.activos.fijos');
Route::get('/admin/tickets-pendientes-usuario', [App\Http\Controllers\TicketController::class, 'pendientesUsuario'])->name('tickets.pendientes.usuario')->middleware('auth','can:tickets.pendientes.usuario');
Route::get('/admin/tickets-pendientes-activos-fijos', [App\Http\Controllers\TicketController::class, 'pendientesActivosFijos'])->name('tickets.pendientes.activos.fijos')->middleware('auth','can:tickets.pendientes.activos.fijos');
Route::get('/admin/tickets-alerta-tiempo', [App\Http\Controllers\TicketController::class, 'alertaTiempo'])->name('tickets.alertaTiempo')->middleware('auth','can:tickets.alertaTiempo');
Route::get('/admin/tickets-historial', [App\Http\Controllers\TicketController::class, 'historial'])->name('tickets.historial')->middleware('auth','can:tickets.historial');
// ============================================
// RUTAS DEL MÓDULO DE REPORTES
// ============================================
Route::get('/admin/reportes', [App\Http\Controllers\ReporteController::class, 'index'])->name('admin.reportes.index')->middleware('auth','can:admin.reportes.index');
Route::get('/admin/reportes/listado-bajas', [App\Http\Controllers\ReporteController::class, 'listadoBajas'])->name('admin.reportes.listado-bajas')->middleware('auth','can:admin.reportes.listado-bajas');
Route::get('/admin/reportes/listado-devueltos', [App\Http\Controllers\ReporteController::class, 'listadoDevueltos'])->name('admin.reportes.listado-devueltos')->middleware('auth','can:admin.reportes.listado-devueltos');

