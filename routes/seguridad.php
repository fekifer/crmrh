<?php

use App\Http\Controllers\Seguridad\RolesController;
use Illuminate\Support\Facades\Route;

Route::resource('roles',RolesController::class)->except(['destroy','show','create'])->only(['index','store','edit','update']);
Route::get('roles/buscar', [RolesController::class,'buscar'])->name('roles.buscar');
Route::get('roles/activarInactivar/{role}', [RolesController::class, 'activarInactivar'])->name('roles.activar-inactivar');
Route::get('roles/eliminar/{role}', [RolesController::class, 'eliminar'])->name('roles.eliminar');
Route::get('roles/verRoles/{role}', [RolesController::class, 'verRoles'])->name('roles.ver-roles');