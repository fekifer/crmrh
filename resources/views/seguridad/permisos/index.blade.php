@extends('layouts.master')
@section('title')
    Catálogo de Permisos
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/gridjs/theme/mermaid.min.css') }}">
@endsection
@section('script')
    <script src="{{ URL::asset('build/js/modules/seguridad/permisos/index.js') }}"></script>
    <script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4 border-0 rounded-0 bg-primary-subtle">
                <div class="card-body pb-0 px-4">
                    <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                        <div class="col-lg-4">
                            <h4 class="mb-0">Catálogo de Permisos</h4>
                        </div>
                        <div class="col-lg-4">
                            <div class="search-box">
                                <input type="text" class="form-control border-0"
                                    id="searchResultList"placeholder="Buscar por nombre" autocomplete="off">
                                <i class="ri-search-line search-icon"></i>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-n5">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <button type="button" class="btn btn-primary w-100 addContact-modal" data-bs-toggle="modal"
                        data-bs-target="#AgregarPermisoModal"><i class="bi bi-plus align-middle"></i>Nuevo</button>
                </div>
            </div>
        </div>

        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <!-- Grid.js generará la tabla aquí -->
                    <div id="gridPermisos" class="table-card" data-url="{{ route('seguridad.permisos.buscar') }}"></div>
                </div>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="AgregarPermisoModal" tabindex="-1" aria-labelledby="AgregarPermisoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header p-4 pb-0 m-2">
                    <h1 class="modal-title fs-5 fw-bold" id="AgregarPermisoModalLabel">Nuevo Permiso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="addContact-btnClose"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body pt-0 p-4">
                    <form id="formAgregarPermiso" autocomplete="off" class="needs-validation p-2" novalidate
                        action="{{ route('seguridad.permisos.store') }}"
                        data-update-url="{{ route('seguridad.permisos.update', ['permiso' => '__PERMISO_ID__']) }}" method="POST">
                        @csrf
                        <input type="hidden" id="rolId-input" class="form-control" value="">
                        <div class="text-center mb-3">

                        </div>
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <label for="name" class="form-label">Nombre del Permiso</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nombre del Permiso" required />
                            </div>
                            <div>
                                <label for="name" class="form-label">Tipo Inicio de Sesión</label>
                                <select class="form-control table-bordered" name="guard_name" id="guard_name">
                                    <option value="0">Seleccione</option>
                                    @foreach ($tiposSesion as $tipo)
                                        <option value="{{ $tipo->TIPO_SESION }}"
                                            {{ old('TIPO_SESION') == $tipo->TIPO_SESION ? 'selected' : '' }}>
                                            {{ $tipo->TIPO_SESION }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-secondary" id="guardar">Agregar Permiso</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection
