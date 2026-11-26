<div class="modal fade" id="EditarRolModal" tabindex="-1" aria-labelledby="EditarRolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header p-4 pb-0 m-2">
                <h1 class="modal-title fs-5 fw-bold" id="EditarRolModalLabel"> Editar Rol </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"> </button>
            </div>
            <div class="modal-body pt-0 p-4">
                <form id="roles-edit-form" action="{{ route('seguridad.roles.update', $roles->id) }}" method="POST" autocomplete="off" class="needs-validation p-2">
                    @csrf
                    @method('PUT')
                    <div class="d-flex flex-column gap-3">
                        <div>
                            <label for="edit_name" class="form-label"> Nombre del Rol </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="edit_name" name="name"
                                   value="{{ old('name', $roles->name) }}" placeholder="Ingrese el nombre del rol" maxlength="255" required>
                            <div class="invalid-feedback">
                                @error('name')
                                    {{ $message }}
                                @else
                                    Ingrese el nombre del rol.
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label for="edit_guard_name" class="form-label"> Tipo de Sesión </label>
                            <select class="form-select @error('guard_name') is-invalid @enderror" name="guard_name" id="edit_guard_name" required>
                                <option value=""> Seleccione </option>
                                @foreach ($tipoSesiones as $tipo)
                                    <option value="{{ $tipo->TIPO_SESION }}" 
                                        @selected(old('guard_name', $roles->guard_name) == $tipo->TIPO_SESION )>
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
                            <button type="submit" class="btn btn-secondary" id="btnActualizarRol"> <i class="ri-save-line me-1"></i>Actualizar Rol</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>