@extends('layouts.master')
@section('title')
    Menús
@endsection
@section('css')
@endsection
@section('content')
    <h1 class="text-3xl font-semibold mb2"> Editar Menú</h1>
    <form class="bg-white rounded-lg p-6 shadow-lg" action="{{ route('security.roles.update', $roles) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" class="form-control" readonly name='STATUS' id='STATUS' value="{{ old('STATUS',$roles->STATUS) }}" />
        <div class="card">
            <div class="card-body p-5">
                <div class="row mb-3">
                    <div class="col-lg-3 ext-end">
                        <label for="name" class="form-label">Código del Rol</label>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" readonly name='CODE_ROLE' id='CODE_ROLE' value="{{ old('CODE_ROLE',$roles->CODE_ROLE) }}" />
                    </div>
                </div>
                <div class="row mb-3  ext-end">
                    <div class="col-lg-3">
                        <label for="email" class="form-label"><code>*</code>Nombre del Rol</label>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name='NOMBRE_ROLE' id='NOMBRE_ROLE' value="{{ old('NOMBRE_ROLE',$roles->NOMBRE_ROLE) }}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="email" class="form-label"><code>*</code>Descripción del Rol</label>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name='DESCRIPCION' id='DESCRIPCION' value="{{ old('DESCRIPCION',$roles->DESCRIPCION) }}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="email" class="form-label"><code>*</code>Días para Caducar Contraseña</label>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name='DIAS_CADUCIDAD' id='DIAS_CADUCIDAD' value="{{ old('DIAS_CADUCIDAD',$roles->DIAS_CADUCIDAD) }}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="email" class="form-label"><code>*</code>Intentos de Logueo Permitidos</label>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name='INTENTOS_LOGUEO' id='INTENTOS_LOGUEO' value="{{ old('INTENTOS_LOGUEO',$roles->INTENTOS_LOGUEO) }}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="email" class="form-label"><code>*</code>Número de Contraseñas Previas</label>
                    </div>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" name='HISTORIA_PASS' id='HISTORIA_PASS' value="{{ old('HISTORIA_PASS',$roles->HISTORIA_PASS) }}"/>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-lg-3">
                        <label for="email" class="form-label"><code>*</code>Negocio</label>
                    </div>
                    <div class="col-lg-4">
                        <select class="form-control table-bordered" name="ID_NEGOCIO" id="ID_NEGOCIO">
                            <option value="0">Seleccione</option>
                            @foreach ($negocios as $negocio)
                                <option value="{{ $negocio->ID_NEGOCIO }}" @selected(old('ID_NEGOCIO', $roles->ID_NEGOCIO) == $negocio->ID_NEGOCIO)>{{ old('ID_NEGOCIO', $negocio->NOMBRE_NEGOCIO) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">
                        Registrar
                    </button>
                    <a class="btn btn-outline-danger" href="{{ route('security.roles.index') }}">Cancelar</a>
                </div>
            </div>
        </div>
    </form>
@endsection
