<?php

namespace App\Http\Controllers\Seguridad;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePruebaRequest;
use App\Http\Requests\UpdatePruebaRequest;
use App\Models\Prueba;
use App\Models\Seguridad\Roles;
use App\Models\Seguridad\TiposSesion;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Roles::all();
        $tipoSesiones = TiposSesion::all();
        return view('seguridad.roles.index', compact('roles','tipoSesiones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipoSesiones = TiposSesion::all();
        return view('seguridad.roles.create',compact('tipoSesiones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Roles::create($request->all());

        return redirect()->route('seguridad.roles.index')->with('success', 'El rol se registró correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Roles $role)
    {
        return view('seguridad.roles.show', ['rol' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $role)
    {
        $roles = Roles::find($role);
        $tipoSesiones = TiposSesion::all();
        return view('seguridad.roles.edit', compact('roles','tipoSesiones'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Roles $role)
    {
        $role->update(
            $request->only([
                'name',
                'guard_name'
            ])
        );

        return redirect()
            ->route('seguridad.roles.index')
            ->with('success', 'Rol actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Roles $role)
    {
        $role->delete();

        return redirect()
            ->route('seguridad.roles.index')
            ->with('success', 'El rol se eliminó correctamente.');
    }
}