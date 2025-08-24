@extends("layouts.header")

@section("contenido")
<style>
    /* Estilos para los badges de estado de resultado */
    .badge-estado-p { background-color: #ef4444; color: white; } /* Rojo para Deficiente */
    .badge-estado-g { background-color: #22c55e; color: white; } /* Verde para Ganado */
    .badge-estado-d { background-color: #facc15; color: black; } /* Amarillo para Pendiente */
</style>
<div class="header-section">
    <div class="header-title">
        <i class="fas fa-chart-bar"></i>
        <span>Administrar Resultados de Alumnos</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center g-2">
                <!-- Barra de búsqueda y filtros -->
                <div class="col-md-12 col-lg-12">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" id="inputBusqueda" class="form-control border-start-0"
                                       placeholder="Buscar por nombre completo..." aria-label="Buscar alumno">
                                <button id="btnBuscar" class="btn btn-success px-3">
                                    Buscar
                                </button>
                                <button id="btnLimpiar" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Limpiar
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-book text-muted"></i>
                                </span>
                                <select id="filtroGrado" class="form-select">
                                    <option value="">Todos los grados</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-calendar-event text-muted"></i>
                                </span>
                                <select id="filtroPeriodo" class="form-select">
                                    <option value="">Todos los periodos</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light" id="estadoResultadoIcon">
                                    <i class="bi bi-check-circle text-muted"></i> 
                                </span>
                                <select id="filtroEstadoResultado" class="form-select">
                                    <option value="">Todos los estados</option>
                                    <option value="G">Ganador</option>
                                    <option value="D">Derecho a recuperación</option>
                                    <option value="P">Perdedor</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaAlumnosResultados" class="table table-hover">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Perfil</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Grado</th>
                            <th scope="col">Promedio General</th>
                            <th scope="col">Estado Resultado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- Las filas de la tabla se llenarán dinámicamente -->
                    </tbody>
                </table>
                <div id="paginacion" class="mt-3">
                    <!-- La paginación se llenará dinámicamente -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const apiBaseUrl = 'http://localhost:3000/alumnos-grado/resultados';
    const gradosApiUrl = 'http://localhost:3000/grados';
    const periodosApiUrl = 'http://localhost:3000/periodos/seleccion'; // Endpoint para períodos, como en tu código base

    let currentPage = 1;
    let totalPages = 1;
    let selectedGradoId = null;
    let selectedPeriodoId = null;
    let selectedEstadoResultado = null;
    let currentSearchTerm = '';

    $(document).ready(function () {
        // Cargar períodos y grados al inicializar
        cargarPeriodos(); // Esto cargará los períodos y luego llamará a cargarAlumnosResultados
        cargarGrados(); // Carga los grados de forma independiente
        // No llamamos a cargarAlumnosResultados aquí directamente, ya que populatePeriodosDropdown lo hará.

        // Event listeners para los filtros
        $('#filtroGrado').on('change', function() {
            selectedGradoId = $(this).val();
            cargarAlumnosResultados(1);
        });

        $('#filtroPeriodo').on('change', function() {
            selectedPeriodoId = $(this).val();
            cargarAlumnosResultados(1);
        });

        $('#filtroEstadoResultado').on('change', function() {
            selectedEstadoResultado = $(this).val();
            updateEstadoResultadoIcon(selectedEstadoResultado);
            cargarAlumnosResultados(1);
        });

        // Event listeners para búsqueda
        $('#btnBuscar').click(function () {
            currentSearchTerm = $('#inputBusqueda').val().trim();
            cargarAlumnosResultados(1);
        });

        $('#inputBusqueda').on('keypress', function(e) {
            if (e.which === 13) { // Tecla Enter
                $('#btnBuscar').click();
            }
        });

        $('#btnLimpiar').on('click', function() {
            $('#inputBusqueda').val('');
            currentSearchTerm = '';
            $('#filtroGrado').val('');
            selectedGradoId = null;
            $('#filtroPeriodo').val('');
            selectedPeriodoId = null;
            $('#filtroEstadoResultado').val('');
            selectedEstadoResultado = null;
            updateEstadoResultadoIcon(''); // Restablecer ícono
            cargarAlumnosResultados(1);
        });
    });

    // Función para actualizar el ícono junto al dropdown de Estado Resultado
    function updateEstadoResultadoIcon(estado) {
        const iconSpan = $('#estadoResultadoIcon');
        iconSpan.empty();
        let iconClass = 'bi bi-check-circle text-muted'; // Ícono por defecto
        if (estado === 'G') {
            iconClass = 'bi bi-check-circle text-success';
        } else if (estado === 'D') {
            iconClass = 'bi bi-x-circle-fill text-danger';
        } else if (estado === 'P') {
            iconClass = 'bi bi-hourglass-split text-warning';
        }
        iconSpan.append(`<i class="${iconClass}"></i>`);
    }

    // Función para cargar períodos
    function cargarPeriodos() {
        $.ajax({
            url: periodosApiUrl,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                populateDropdown($('#filtroPeriodo'), data, 'ID_PERIODO_ESCOLAR', 'DESCRIPCION_PERIODO', 'Todos los periodos');
                // Seleccionar automáticamente el primer período si hay períodos disponibles
                if (data.length > 0) {
                    selectedPeriodoId = data[0].ID_PERIODO_ESCOLAR;
                    $('#filtroPeriodo').val(selectedPeriodoId);
                    // Cargar la tabla con el período seleccionado por defecto
                    cargarAlumnosResultados(1);
                } else {
                    cargarAlumnosResultados(1); // Cargar sin período si no hay ninguno
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar períodos:', error);
                // Si hay un error al cargar períodos, aún intentamos cargar los alumnos
                cargarAlumnosResultados(1);
            }
        });
    }

    // Función para cargar grados (para el filtro de grados)
    function cargarGrados() {
        $.ajax({
            url: gradosApiUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                populateDropdown($('#filtroGrado'), response.data, 'ID_GRADO', 'NOMBRE_GRADO', 'Todos los grados');
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar grados:', error);
            }
        });
    }

    // Función genérica para llenar dropdowns
    function populateDropdown(dropdownElement, data, valueKey, textKey, defaultOptionText) {
        dropdownElement.empty();
        dropdownElement.append($('<option>', {
            value: '',
            text: defaultOptionText
        }));
        $.each(data, function(index, item) {
            dropdownElement.append($('<option>', {
                value: item[valueKey],
                text: item[textKey]
            }));
        });
    }

    // Función para cargar los resultados de alumnos
    function cargarAlumnosResultados(page = 1) {
        const requestData = {
            ID_PERIODO_ESCOLAR: selectedPeriodoId ? parseInt(selectedPeriodoId) : null,
            ID_GRADO: selectedGradoId ? parseInt(selectedGradoId) : null,
            NOMBRE_COMPLETO: currentSearchTerm || null,
            ESTADO_RESULTADO: selectedEstadoResultado || null,
            page: page,
            limit: 10 // Límite fijo desde tu endpoint de backend
        };

        const tbody = $('#tablaAlumnosResultados tbody');
        tbody.empty();
        tbody.append('<tr><td colspan="7" class="text-center py-4">Cargando alumnos...</td></tr>');

        $.ajax({
            url: apiBaseUrl,
            type: 'POST',
            dataType: 'json',
            contentType: 'application/json',
            data: JSON.stringify(requestData),
            cache: false,
            success: function (response) {
                const data = response.data;
                const pagination = response.pagination;
                currentPage = pagination.currentPage;
                totalPages = pagination.totalPages;

                tbody.empty();

                if (data.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center py-4">No se encontraron resultados de alumnos.</td></tr>');
                } else {
                    data.forEach(alumno => {
                        let estadoResultadoClass = '';
                        switch (alumno.ESTADO_RESULTADO) {
                            case 'D':
                                estadoResultadoClass = 'badge-estado-d';
                                break;
                            case 'G':
                                estadoResultadoClass = 'badge-estado-g';
                                break;
                            case 'P':
                                estadoResultadoClass = 'badge-estado-p';
                                break;
                            default:
                                estadoResultadoClass = 'bg-secondary text-white';
                                break;
                        }

                        const fila = `
                            <tr>
                                <td>${alumno.PERFIL_PERSONA || 'N/A'}</td>
                                <td class="text-start">${alumno.NOMBRE_COMPLETO || 'N/A'}</td>
                                <td class="text-start">${alumno.NOMBRE_GRADO || 'N/A'}</td>
                                <td>
                                <span style="background-color: green; color: white; padding: 2px 4px; border-radius: 3px;">
                                    ${alumno.PROMEDIO_GENERAL !== null ? alumno.PROMEDIO_GENERAL.toFixed(2) : 'N/A'}
                                </span>
                                </td>
                                <td>
                                    <span class="badge ${estadoResultadoClass}" style="padding: 5px 10px; font-size: 14px;">
                                        ${alumno.DESCRIPCION_ESTADO_ESULTADO || 'N/A'}
                                    </span>
                                </td>
                                <td>
                                    <a href="/alumnos-resultados/${alumno.ID_ALUMNO_GRADO}"
                                       class="btn btn-primary btn-sm">
                                        <i class="bi bi-info-circle me-1"></i> Ver Detalles
                                    </a>
                                </td>
                            </tr>
                        `;
                        tbody.append(fila);
                    });
                }
                actualizarPaginacion();
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar los alumnos:', error);
                tbody.html('<tr><td colspan="7" class="text-center py-4 text-danger">Error al cargar datos. Por favor, intente de nuevo.</td></tr>');
                totalPages = 1; // Restablecer totalPages en caso de error
                actualizarPaginacion();
            }
        });
    }

    // Función de paginación (adaptada para llamar a cargarAlumnosResultados)
    function actualizarPaginacion() {
        const paginationContainer = $('#paginacion');
        paginationContainer.empty();

        if (totalPages <= 1) {
            return;
        }

        let paginationHTML = `
            <nav aria-label="Navegación de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
        `;

        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);

        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }

        if (startPage > 1) {
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="1">1</a>
                </li>
            `;
            if (startPage > 2) {
                paginationHTML += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `;
            }
        }

        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                paginationHTML += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `;
            }
            paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                </li>
            `;
        }

        paginationHTML += `
                    <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `;

        paginationContainer.html(paginationHTML);

        $('.page-link').on('click', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page >= 1 && page <= totalPages) {
                cargarAlumnosResultados(page);
            }
        });
    }

    // Llamada inicial para actualizar el ícono de Estado Resultado
    updateEstadoResultadoIcon('');
</script>

@endsection