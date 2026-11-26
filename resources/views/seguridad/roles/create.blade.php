<div class="modal fade" id="AgregarRolModal" tabindex="-1" aria-labelledby="addRolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-4 pb-0 m-2">
                <h1 class="modal-title fs-5 fw-bold" id="addRolModalLabel">
                    Agregar Rol
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" id="addRol-btnClose" aria-label="Cerrar">
                </button>
            </div>
            <div class="modal-body pt-0 p-4">
                <form id="roles-form" action="{{ route('seguridad.roles.store') }}" method="POST" autocomplete="off" class="needs-validation p-2">
                    @csrf
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label for="name" class="form-label"> Nombre del Rol </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Ingrese el nombre del rol" maxlength="255" required>
                            <div class="invalid-feedback">
                                @error('name')
                                    {{ $message }}
                                @else
                                    Ingrese el nombre del rol.
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="guard_name" class="form-label"> Tipo de Sesión </label>
                            <select class="form-control table-bordered" name="guard_name" id="guard_name">
                                    <option value="0">Seleccione</option>
                                    @foreach ($tipoSesiones as $tipo)
                                        <option value="{{ $tipo->TIPO_SESION }}"
                                            {{ old('TIPO_SESION') == $tipo->TIPO_SESION ? 'selected' : '' }}>
                                            {{ $tipo->TIPO_SESION }}
                                        </option>
                                    @endforeach
                                </select>
                            <div class="invalid-feedback">
                                @error('guard_name')
                                    {{ $message }}
                                @else
                                    Seleccione el tipo de sesión.
                                @enderror
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal"> Cancelar </button>
                            <button type="submit" class="btn btn-secondary" id="addNewRol"> <i class="ri-save-line me-1"></i> Guardar Rol </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
