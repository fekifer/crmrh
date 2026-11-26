
document.addEventListener('DOMContentLoaded', function () {

    // ==========================================
    // 1. INICIALIZAR GRID.JS
    // ==========================================

    const contenedor = document.getElementById('tabla-roles');

    if (!contenedor) {
        console.error('No existe el contenedor tabla-roles');
        return;
    }

    // Obtener registros enviados desde Eloquent
    const roles = JSON.parse(contenedor.dataset.roles || '[]');
    const rutaMostrar = contenedor.dataset.rutaMostrar;
    const rutaEditar = contenedor.dataset.rutaEditar;
    const rutaEliminar = contenedor.dataset.rutaEliminar;
    // Preparar los registros para Grid.js
    const registros = roles.map(rol => [
        rol.id,
        rol.name,
        rol.id
    ]);

    // Limpiar contenedor de Grid.js
    contenedor.replaceChildren();

    // Crear Grid.js
    new gridjs.Grid({
        columns: [
            {
                name: 'ID',
                width: '100px'
            },
            {
                name: 'Rol'
            },

            {
                name: 'Acciones',
                width: '150px',
                sort: false,

                formatter: (id) => {

                    // ==================================
                    // ENLACE EDITAR
                    // ==================================

                    const urlEditar = rutaEditar.replace('__ID__', encodeURIComponent(id));

                    const editar = document.createElement('a');

                    editar.href = urlEditar;
                    editar.className = 'bi bi-pencil-fill editar-rol me-3';
                    editar.title = 'Editar rol';
                    editar.setAttribute('aria-label', 'Editar rol');


                    // ==========================================
                    // ENLACE MOSTRAR DETALLE
                    // ==========================================

                    const urlMostrar = rutaMostrar.replace('__ID__', encodeURIComponent(id));

                    const mostrar = document.createElement('a');

                    mostrar.href = urlMostrar;
                    mostrar.className = 'bi bi-eye-fill mostrar-rol me-3';
                    mostrar.title = 'Ver detalle del rol';
                    mostrar.setAttribute('aria-label', 'Ver detalle del rol');


                    // ==================================
                    // ENLACE ELIMINAR
                    // ==================================

                    const urlEliminar = rutaEliminar.replace('__ID__', encodeURIComponent(id));

                    const eliminar = document.createElement('a');

                    eliminar.href = urlEliminar;
                    eliminar.className = 'bi bi-trash3-fill eliminar-rol text-danger';
                    eliminar.dataset.id = String(id);
                    eliminar.title = 'Eliminar rol';
                    eliminar.setAttribute('aria-label', 'Eliminar rol');


                    // ==================================
                    // MOSTRAR AMBOS ENLACES
                    // ==================================

                    return gridjs.html(
                        mostrar.outerHTML + editar.outerHTML + eliminar.outerHTML
                    );
                }
            }
        ],

        data: registros,

        search: true,
        sort: true,

        pagination: {
            enabled: true,
            limit: 10
        },

        language: {
            search: {
                placeholder: 'Buscar rol...'
            },
            pagination: {
                previous: 'Anterior',
                next: 'Siguiente'
            },
            noRecordsFound: 'No se encontraron registros'
        }

    }).render(contenedor);


    // ==========================================
    // 2. MODAL DE CREACIÓN
    // ==========================================

    const configuracion = document.getElementById('configuracionRol');

    if (configuracion?.dataset.abrirModal === '1') {

        const elemento = document.getElementById('AgregarRolModal');

        if (elemento) {
            bootstrap.Modal.getOrCreateInstance(elemento).show();
        }
    }

    // ==========================================
    // 3. MODAL DE EDICIÓN
    // ==========================================

    const contenedorEditar = document.getElementById(
        'contenedor-modal-editar'
    );

    contenedor.addEventListener('click', async function (evento) {

        const enlace = evento.target.closest('.editar-rol');

        if (!enlace) return;

        // Evitar navegar a otra página
        evento.preventDefault();

        if (!contenedorEditar) {
            console.error('No existe contenedor-modal-editar');
            return;
        }

        try {

            // Ejecutar RolesController@edit
            const respuesta = await fetch(enlace.href);

            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            // Recibir el HTML de edit.blade.php
            contenedorEditar.innerHTML = await respuesta.text();

            // Abrir modal Bootstrap
            const elemento = contenedorEditar.querySelector('#EditarRolModal');

            if (!elemento) {
                throw new Error('No se encontró EditarRolModal');
            }

            const modal = bootstrap.Modal.getOrCreateInstance(elemento);

            // Limpiar el modal cuando se cierre
            elemento.addEventListener('hidden.bs.modal', function () {
                modal.dispose();
                contenedorEditar.replaceChildren();
            }, { once: true });

            modal.show();

        } catch (error) {
            console.error('Error al cargar el formulario:', error);
            alert('No fue posible abrir el formulario de edición.');
        }

    });


    // ==========================================
    // 4. ELIMINAR ROL
    // ==========================================

    const formularioEliminar = document.getElementById(
        'formEliminarRol'
    );

    if (!formularioEliminar) {
        console.error('No existe el formulario formEliminarRol');
        return;
    }

    // Capturar clic en el icono Eliminar de Grid.js
    contenedor.addEventListener('click', async function (evento) {

        const enlace = evento.target.closest('.eliminar-rol');

        if (!enlace) return;

        // Evitar la navegación GET de la etiqueta <a>
        evento.preventDefault();

        // Obtener el identificador del rol
        const id = enlace.dataset.id;

        // Buscar el rol seleccionado
        const rol = roles.find(
            registro => String(registro.id) === String(id)
        );

        if (!rol) {
            console.error('No se encontró el rol:', id);
            return;
        }

        // ==========================================
        // CONFIRMACIÓN CON SWEETALERT2
        // ==========================================

        const resultado = await Swal.fire({
            title: '¿Eliminar rol?',
            text: `¿Estás seguro de eliminar el rol "${rol.name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            reverseButtons: true,
            focusCancel: true
        });

        // Si el usuario cancela, no eliminar
        if (!resultado.isConfirmed) {
            return;
        }

        // ==========================================
        // EJECUTAR DESTROY()
        // ==========================================

        // Asignar la ruta de eliminación
        formularioEliminar.action = enlace.href;

        // Enviar formulario al Controller
        formularioEliminar.requestSubmit();
    });


    // ==========================================
    // 5. MOSTRAR DETALLE DEL ROL
    // ==========================================

    const contenedorMostrar = document.getElementById(
        'contenedor-modal-mostrar'
    );

    contenedor.addEventListener('click', async function (evento) {

        const enlace = evento.target.closest('.mostrar-rol');

        if (!enlace) return;

        // Evitar navegación GET a otra página
        evento.preventDefault();

        if (!contenedorMostrar) {
            console.error('No existe contenedor-modal-mostrar');
            return;
        }

        try {
            // Ejecutar RolesController@show
            const respuesta = await fetch(enlace.href, {
                method: 'GET',
                headers: {
                    'Accept': 'text/html'
                }
            });

            if (!respuesta.ok) {
                throw new Error(`Error HTTP: ${respuesta.status}`);
            }

            // Obtener HTML de show.blade.php
            contenedorMostrar.innerHTML = await respuesta.text();

            // Buscar modal de detalle
            const elemento = contenedorMostrar.querySelector(
                '#MostrarRolModal'
            );

            if (!elemento) {
                throw new Error('No se encontró MostrarRolModal');
            }

            // Inicializar y abrir modal
            const modal = bootstrap.Modal.getOrCreateInstance(
                elemento
            );

            elemento.addEventListener('hidden.bs.modal', function () {
                modal.dispose();
                contenedorMostrar.replaceChildren();
            }, { once: true });

            modal.show();

        } catch (error) {
            console.error('Error al consultar el rol:', error);
            alert('No fue posible mostrar el detalle del rol.');
        }

    });

});