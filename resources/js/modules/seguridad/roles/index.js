
document.addEventListener('DOMContentLoaded', async function () {

    // ==========================================
    // 1. ELEMENTOS DEL BLADE
    // ==========================================
    const contenedor = document.getElementById('gridRoles');
    const buscador = document.getElementById('searchResultList');

    const modalElemento = document.getElementById('AgregarRolModal');
    const formulario = document.getElementById('formAgregarRol');
    const inputNombre = document.getElementById('name');
    const selectGuard = document.getElementById('guard_name');
    const tituloModal = document.getElementById('AgregarRolModalLabel');
    const botonGuardar = document.getElementById('guardar');

    const botonNuevo = document.querySelector(
        '[data-bs-target="#AgregarRolModal"]'
    );

    if (!contenedor) {
        console.error('No existe el contenedor gridRoles');
        return;
    }

    if (typeof gridjs === 'undefined') {
        console.error('La librería Grid.js no está cargada');
        return;
    }

    const urlAjax = contenedor.dataset.url;

    // Guardar la URL original del formulario
    const urlCrear = formulario?.action || '';

    let grid = null;
    let rolesOriginales = [];

    // ==========================================
    // 2. CONSULTAR ROLES
    // ==========================================
    async function obtenerRoles() {

        const respuesta = await fetch(urlAjax, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });

        if (!respuesta.ok) {
            throw new Error(`Error HTTP ${respuesta.status}`);
        }

        const texto = await respuesta.text();

        if (!texto.trim()) {
            return [];
        }

        const resultado = JSON.parse(texto);

        if (Array.isArray(resultado)) {
            return resultado;
        }

        if (Array.isArray(resultado?.data)) {
            return resultado.data;
        }

        if (Array.isArray(resultado?.data?.data)) {
            return resultado.data.data;
        }

        if (Array.isArray(resultado?.data?.original?.data)) {
            return resultado.data.original.data;
        }

        if (resultado?.data == null) {
            return [];
        }

        throw new Error(
            'La estructura de respuesta de RolesManager no es válida'
        );
    }

    // ==========================================
    // 3. CREAR GRID.JS
    // ==========================================
    function crearGrid(roles = []) {

        grid = new gridjs.Grid({
            columns: [
                {
                    id: 'id',
                    name: 'Número de Rol',
                    width: '150px',
                    sort: true
                },
                {
                    id: 'name',
                    name: 'Nombre del Rol',
                    sort: true
                },
                {
                    id: 'guard_name',
                    name: 'Tipo de Sesión',
                    sort: true,
                    formatter: (cell) => {
                        return cell ?? 'Sin asignar';
                    }
                },
                {
                    id: 'status',
                    name: 'Estado',
                    width: '160px',
                    sort: true,
                    formatter: (cell) => {
                        return Number(cell) === 1
                            ? gridjs.html(
                                '<span class="badge bg-success">Activo</span>'
                            )
                            : gridjs.html(
                                '<span class="badge bg-danger">Inactivo</span>'
                            );
                    }
                },
                {
                    id: 'action',
                    name: 'Acciones',
                    width: '130px',
                    sort: false,
                    formatter: (cell) => {
                        // Usar solamente HTML generado
                        // de forma confiable en el backend
                        return gridjs.html(cell || '');
                    }
                }
            ],

            data: roles,

            search: false,
            sort: true,

            pagination: {
                enabled: true,
                limit: 10
            },

            language: {
                noRecordsFound: 'No hay roles registrados',
                pagination: {
                    previous: 'Anterior',
                    next: 'Siguiente',
                    showing: 'Mostrando',
                    to: 'a',
                    of: 'de',
                    results: () => 'registros'
                }
            }
        });

        grid.render(contenedor);
    }

    // ==========================================
    // 4. ACTUALIZAR GRID
    // ==========================================
    function actualizarGrid(roles) {

        if (!grid) {
            crearGrid(roles);
            return;
        }

        grid.updateConfig({
            data: roles
        }).forceRender();
    }

    // ==========================================
    // 5. FILTRAR ROLES
    // ==========================================
    function filtrarRoles() {

        const texto = buscador
            ? buscador.value.trim().toLowerCase()
            : '';

        const rolesFiltrados = rolesOriginales.filter(rol =>
            String(rol.name ?? '')
                .toLowerCase()
                .includes(texto)
        );

        actualizarGrid(rolesFiltrados);
    }

    // ==========================================
    // 6. CONFIGURAR FORMULARIO
    // ==========================================
    function configurarMetodoFormulario(metodo) {

        if (!formulario) {
            return;
        }

        // Laravel utiliza POST con _method=PUT
        // para actualizar registros.
        let campoMetodo = formulario.querySelector(
            'input[name="_method"]'
        );

        if (metodo === 'PUT') {

            if (!campoMetodo) {
                campoMetodo = document.createElement('input');
                campoMetodo.type = 'hidden';
                campoMetodo.name = '_method';
                formulario.appendChild(campoMetodo);
            }

            campoMetodo.value = 'PUT';

        } else {

            if (campoMetodo) {
                campoMetodo.remove();
            }
        }

        formulario.method = 'POST';
    }

    // ==========================================
    // 7. PREPARAR MODAL PARA CREAR
    // ==========================================
    function prepararNuevoRol() {

        if (!formulario) {
            return;
        }

        formulario.reset();

        formulario.action = urlCrear;

        configurarMetodoFormulario('POST');

        if (tituloModal) {
            tituloModal.textContent = 'Nuevo Rol';
        }

        if (botonGuardar) {
            botonGuardar.textContent = 'Agregar Rol';
        }

        formulario.classList.remove('was-validated');
    }

    // ==========================================
    // 8. PREPARAR MODAL PARA EDITAR
    // ==========================================
    function editarRol(idRol) {

        const rol = rolesOriginales.find(
            item => String(item.id) === String(idRol)
        );

        if (!rol) {
            console.error('No se encontró el rol:', idRol);
            return;
        }

        if (!formulario || !modalElemento) {
            console.error('No se encontró el formulario o modal');
            return;
        }

        // Limpiar valores anteriores
        formulario.reset();

        // URL de actualización
        const urlActualizar = formulario.dataset.updateUrl;

        formulario.action = urlActualizar.replace('__ROLE_ID__', encodeURIComponent(rol.id));

        configurarMetodoFormulario('PUT');

        // Colocar información del rol
        if (inputNombre) {
            inputNombre.value = rol.name ?? '';
        }
        if(selectGuard){
            selectGuard.value = rol.guard_name ?? '';
        }
        if (tituloModal) {
            tituloModal.textContent = 'Editar Rol';
        }

        if (botonGuardar) {
            botonGuardar.textContent = 'Guardar Cambios';
        }

        formulario.classList.remove('was-validated');

        // Abrir modal Bootstrap
        if (typeof bootstrap !== 'undefined') {
            const modal = bootstrap.Modal.getOrCreateInstance(
                modalElemento
            );

            modal.show();
        } else {
            console.error('Bootstrap Modal no está disponible');
        }
    }

    // ==========================================
    // 9. EVENTOS DE ACCIONES
    // ==========================================

    // Delegación de eventos:
    // funciona aunque Grid.js regenere las filas
    contenedor.addEventListener('click', function (event) {

        const botonEditar = event.target.closest(
            '.btn-editar-rol'
        );

        if (!botonEditar) {
            return;
        }

        event.preventDefault();

        const idRol = botonEditar.dataset.id;

        editarRol(idRol);
    });

    // Preparar modal para registrar un rol nuevo
    if (botonNuevo) {
        botonNuevo.addEventListener('click', function () {
            prepararNuevoRol();
        });
    }

    // Buscar mientras el usuario escribe
    if (buscador) {
        buscador.addEventListener('input', filtrarRoles);
    }

    // ==========================================
    // 10. CARGAR ROLES
    // ==========================================
    async function cargarRoles() {

        try {

            contenedor.setAttribute('aria-busy', 'true');

            const roles = await obtenerRoles();

            rolesOriginales = roles;

            filtrarRoles();

        } catch (error) {

            console.error('Error al cargar roles:', error);

            if (!grid) {
                const mensaje = document.createElement('div');

                mensaje.className = 'alert alert-danger';
                mensaje.textContent =
                    'No fue posible cargar el catálogo de roles.';

                contenedor.replaceChildren(mensaje);
            }

        } finally {

            contenedor.removeAttribute('aria-busy');
        }
    }

    // ==========================================
    // 11. INICIALIZACIÓN
    // ==========================================
    await cargarRoles();

    // Permite recargar el grid desde otros scripts
    window.recargarGridRoles = cargarRoles;

});