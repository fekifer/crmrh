<?php

use App\Http\Controllers\Seguridad\PermisosController;
use App\Http\Controllers\Seguridad\RolesController;
use Illuminate\Support\Facades\Route;

Route::resource('roles',RolesController::class);

//permisos
Route::resource('permisos',PermisosController::class)->except(['destroy','show','create'])->only(['index','store','edit','update']);
Route::get('permisos/buscar', [PermisosController::class,'buscar'])->name('permisos.buscar');
Route::get('permisos/activarInactivar/{permiso}', [PermisosController::class, 'activarInactivar'])->name('permisos.activar-inactivar');
Route::get('permisos/eliminar/{permiso}', [PermisosController::class, 'eliminar'])->name('permisos.eliminar');