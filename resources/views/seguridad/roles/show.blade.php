
<div class="modal fade"
     id="MostrarRolModal"
     tabindex="-1"
     aria-labelledby="MostrarRolModalLabel"
     aria-hidden="true">

    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header p-4 pb-0 m-2">
                <h1 class="modal-title fs-5 fw-bold"
                    id="MostrarRolModalLabel">
                    Detalle del Rol
                </h1>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Cerrar">
                </button>
            </div>

            <div class="modal-body pt-0 p-4">

                <div class="d-flex flex-column gap-3 p-2">

                    <div>
                        <label class="form-label">ID del Rol</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $rol->id }}"
                               readonly>
                    </div>

                    <div>
                        <label class="form-label">Nombre del Rol</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $rol->name }}"
                               readonly>
                    </div>

                    <div>
                        <label class="form-label">Tipo de Sesión</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $rol->guard_name }}"
                               readonly>
                    </div>

                    <div>
                        <label class="form-label">Estado</label>
                        <input type="text"
                               class="form-control"
                               value="{{ $rol->status == 1 ? 'Activo' : 'Inactivo' }}"
                               readonly>
                    </div>

                    <div class="text-end">
                        <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
