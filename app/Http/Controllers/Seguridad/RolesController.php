<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Managers\Seguridad\RolesManager;
use App\Models\Seguridad\Roles;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $rolesManager = new RolesManager($request);
        $tiposSesion = $rolesManager->obtenerGuard();
        return view('seguridad.roles.index', compact('tiposSesion'));
    }
    public function buscar(Request $request)
    {
        if ($request->ajax()) {
            $roles = new RolesManager($request);
            $resultado = $roles->buscarTodos();
            return response()->json(['data' => $resultado ?? []]);
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Roles::create($request->all());
        return redirect('seguridad/roles');
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Roles $role)
    {
        $role->update($request->all());
        return redirect('seguridad/roles');
    }
    public function eliminar(Roles $role)
    {
        $roles = new RolesManager($role);
        $roles->eliminarRol();
        return redirect('security/roles');
    }
    public function activarInactivar(Roles $role)
    {
        $roles = new RolesManager($role);
        $roles->activarInactivarRol();
        return redirect('security/roles');
    }
    public function verRoles(Roles $role)
    {
        $roles = new RolesManager($role);
        $roles->cambiarVisibilidad();
        return redirect('seguridad/roles');
    }
}
