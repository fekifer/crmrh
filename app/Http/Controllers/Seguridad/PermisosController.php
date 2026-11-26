<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Managers\Seguridad\PermisosManager;
use App\Models\Seguridad\Permisos;
use Illuminate\Http\Request;

class PermisosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permisosManager = new PermisosManager($request);
        $tiposSesion = $permisosManager->obtenerGuard();
        return view('seguridad.permisos.index', compact('tiposSesion'));
    }
    public function buscar(Request $request)
    {
        if ($request->ajax()) {
            $permisos = new PermisosManager($request);
            $resultado = $permisos->buscarTodos();
            return response()->json(['data' => $resultado ?? []]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Permisos::create($request->all());
        return redirect('seguridad/permisos');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permisos $permiso)
    {
        $permiso->update($request->all());
        return redirect('seguridad/permisos');
    }
    public function eliminar(Permisos $permiso)
    {
        $permisos = new PermisosManager($permiso);
        $permisos->eliminarPermiso();
        return redirect('seguridad/permisos');
    }
    public function activarInactivar(Permisos $permiso)
    {
        /*echo '<pre>';
        dd($permiso->toArray());
        die;*/
        $permisos = new PermisosManager($permiso);
        $permisos->activarInactivarPermiso();
        return redirect('seguridad/permisos');
    }
}
