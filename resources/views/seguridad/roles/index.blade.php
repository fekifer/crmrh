@extends('layouts.master')
@section('title')
    Catálogo de Roles
@endsection
@section('css')
    <link rel="stylesheet" href="{{ asset('build/libs/gridjs/theme/mermaid.min.css') }}">
@endsection
@section('script')
    <script src="{{ URL::asset('build/libs/gridjs/gridjs.umd.js') }}"></script>
    <script src="{{ URL::asset('build/js/modules/seguridad/roles/index.js') }}"></script>
    <script src="{{ URL::asset('/build/libs/sweetalert2/sweetalert2.all.min.js') }}"></script>
@endsection
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mt-n4 mx-n4 border-0 rounded-0 bg-primary-subtle">
                <div class="card-body pb-0 px-4">
                    <div class="row justify-content-between align-items-center g-3 mb-5 pb-1 pt-3">
                        <div class="col-lg-4">
                            <h4 class="mb-0">Catálogo de Roles</h4>
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
                        data-bs-target="#AgregarRolModal"><i class="bi bi-plus align-middle"></i>Nuevo</button>
                </div>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="card">
                <div class="card-body">
                    <!-- Grid.js generará la tabla aquí -->

                    <div id="tabla-roles" data-roles="{{ $roles->toJson() }}"
                        data-ruta-mostrar="{{ route('seguridad.roles.show', ['role' => '__ID__']) }}"
                        data-ruta-editar="{{ route('seguridad.roles.edit', ['role' => '__ID__']) }}"
                        data-ruta-eliminar="{{ route('seguridad.roles.destroy', ['role' => '__ID__']) }}">
                    </div>

                </div>
            </div>
        </div>
    </div>
    {{-- Modal para crear roles --}}
    @include('seguridad.roles.create')

    {{-- Aquí cargaremos dinámicamente edit.blade.php --}}
    <div id="contenedor-modal-editar"></div>

    <!-- Aquí se cargará show.blade.php -->
    <div id="contenedor-modal-mostrar"></div>

    {{-- Configuración existente --}}
    <div id="configuracionRol" data-abrir-modal="{{ ($abrirModalCrear ?? false) || $errors->any() ? '1' : '0' }}" hidden>
    </div>


    {{-- Formulario para eliminar roles --}}
    <form id="formEliminarRol" method="POST" class="d-none">

        @csrf
        @method('DELETE')

    </form>
@endsection
