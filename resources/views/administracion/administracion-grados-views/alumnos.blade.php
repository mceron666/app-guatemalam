@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">

<style>
.header-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    margin-bottom: 20px;
}

.header-title {
    font-size: 36px;
    font-weight: bold;
    margin-bottom: 10px;
}

.student-selector-card {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 1px solid #e3e6f0;
    margin-bottom: 20px;
}

.search-input {
    border: 2px solid #e3e6f0;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.search-input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.student-card {
    border: 1px solid #e3e6f0;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.student-card:hover {
    border-color: #667eea;
    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.2);
}

.student-card.selected {
    border-color: #28a745;
    background-color: #f8fff9;
    box-shadow: 0 2px 8px rgba(40, 167, 69, 0.2);
}

.student-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea, #764ba2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 1.2rem;
}

.student-info h6 {
    margin: 0;
    font-weight: 600;
    color: #2d3748;
}

.student-info small {
    color: #718096;
}

.status-badge {
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
}

.status-ganado {
    background-color: #d4edda;
    color: #155724;
}

.status-perdido {
    background-color: #f8d7da;
    color: #721c24;
}

.status-nuevo {
    background-color: #d1ecf1;
    color: #0c5460;
}

.students-grid {
    max-height: 400px;
    overflow-y: auto;
}

.loading-spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 20px auto;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.stats-card {
    background: linear-gradient(135deg, #28a745, #20c997);
    color: white;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    margin-bottom: 20px;
}

.stats-number {
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.stats-label {
    font-size: 0.9rem;
    opacity: 0.9;
}
</style>

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-users"></i>
        <span>Administración de Alumnos por Grado</span>  
        <div style="font-size: 20px; margin-top: 10px;">
            Período: <span id="header-periodo-codigo" style="font-weight: 500;">Cargando...</span> |
            Grado: <span id="header-grado-nombre" style="font-weight: 500;">Cargando...</span>
        </div>                  
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        Alumnos Asignados al Grado
                    </h5>
                </div>
                <div class="col-md-3">
                    <div class="stats-card">
                        <div class="stats-number" id="totalAlumnos">0</div>
                        <div class="stats-label">Total Alumnos</div>
                    </div>
                </div>
                <div class="col-md-3 text-end">
                    <button type="button" class="btn btn-primary btn-lg" id="agregar" data-bs-toggle="modal" data-bs-target="#asignacionModal">
                        <i class="bi bi-plus-circle me-1"></i>Asignar Alumno
                    </button>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="tablaAlumnos" class="table table-striped">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col" width="15%">Perfil</th>
                            <th scope="col" width="35%">Nombre Completo</th>                            
                            <th scope="col" width="20%">Grado</th>
                            <th scope="col" width="10%">Estado</th>
                            <th scope="col" width="15%">Fecha Asignación</th>
                            <th scope="col" width="5%">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td colspan="6" class="text-center">
                                <div class="loading-spinner"></div>
                                <p>Cargando alumnos asignados...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div id="paginacion" class="mt-3"></div>                
            </div>
        </div>
    </div>
</div>

<!-- Modal para Asignación de Alumnos -->
<div class="modal fade custom-modal" id="asignacionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header text-white" style="background-color: #198754;">
                <div class="d-flex align-items-center">
                    <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
                    <h4 class="modal-title" id="titulo">Asignar Alumno al Grado</h4>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <div id="errorMessageContainer" class="alert alert-danger mx-4 mt-3 mb-0 d-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="errorMessage">Mensaje de error aquí</span>
                </div>
            </div>
            
            <div class="modal-body p-4">
                <div class="row g-4">
                    <!-- Información del Grado -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Información del Grado
                                </h5>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Período Escolar</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                                        <input type="text" class="form-control" id="periodoSeleccionado" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Grado</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                                        <input type="text" class="form-control" id="gradoSeleccionado" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Nivel</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-layer-group"></i></span>
                                        <input type="text" class="form-control" id="nivelGrado" readonly>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Carrera</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-certificate"></i></span>
                                        <input type="text" class="form-control" id="carreraGrado" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Selector de Alumnos -->
                    <div class="col-md-8">
                        <div class="student-selector-card">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-users text-primary me-2"></i>
                                Alumnos Disponibles para Asignar
                            </h5>
                            
                            <!-- Buscador -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    <input type="text" class="form-control search-input" id="buscarAlumno" 
                                           placeholder="Filtrar por nombre del alumno...">
                                    <button class="btn btn-outline-secondary" type="button" id="btnBuscar">
                                        <i class="fas fa-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Resultados de búsqueda -->
                            <div class="students-grid" id="resultadosAlumnos">
                                <div class="text-center py-3">
                                    <div class="loading-spinner"></div>
                                    <p>Cargando alumnos disponibles...</p>
                                </div>
                            </div>
                            
                            <!-- Alumno seleccionado -->
                            <div class="mt-3" id="alumnoSeleccionado" style="display: none;">
                                <div class="alert alert-success">
                                    <h6><i class="fas fa-check-circle me-2"></i>Alumno Seleccionado:</h6>
                                    <div id="infoAlumnoSeleccionado"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Campos ocultos -->
                <input type="hidden" id="alumnoIdSeleccionado">
                <input type="hidden" id="periodoId">
                <input type="hidden" id="gradoId">
                <input type="hidden" id="carreraId">
                <input type="hidden" id="nivelId">
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success btn-lg px-4" id="btnGuardar" disabled>
                    <i class="bi bi-check-circle me-2"></i>Asignar Alumno
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    
const apiBaseUrl = 'http://localhost:3000';

// Obtener parámetros de la URL
function getUrlParameters() {
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Buscar el índice de 'alumnos' en la URL
    const alumnosIndex = segments.indexOf('alumnos');
    
    if (alumnosIndex !== -1 && segments.length > alumnosIndex + 2) {
        return {
            periodo: parseInt(segments[alumnosIndex + 1]),
            grado: parseInt(segments[alumnosIndex + 2])
        };
    }
    
    return { periodo: null, grado: null };
}

// Variables globales
let urlParams = getUrlParameters();
let currentPage = 1;
let totalPages = 1;
let gradoInfo = null;
let alumnoSeleccionado = null;
let todosLosAlumnos = []; // Para almacenar todos los alumnos y filtrar localmente

// Cargar información del período y grado
function cargarInfoPeriodoGrado() {
    if (!urlParams.periodo || !urlParams.grado) {
        console.error('Parámetros de URL no válidos');
        return;
    }
    
    // Cargar información del período
    axios.get(`${apiBaseUrl}/periodos/seleccion`)
        .then(response => {
            const periodos = response.data;
            const periodo = periodos.find(p => p.ID_PERIODO_ESCOLAR == urlParams.periodo);
            if (periodo) {
                document.getElementById('header-periodo-codigo').textContent = periodo.CODIGO_PERIODO;
                document.getElementById('periodoSeleccionado').value = periodo.DESCRIPCION_PERIODO;
                document.getElementById('periodoId').value = periodo.ID_PERIODO_ESCOLAR;
            }
        })
        .catch(error => {
            console.error('Error al cargar información del período:', error);
        });
    
    // Cargar información del grado
    $.ajax({
        url: `${apiBaseUrl}/grados/${urlParams.grado}/i`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const grado = response.data[0];
            if (grado) {
                gradoInfo = grado;
                document.getElementById('header-grado-nombre').textContent = grado.NOMBRE_GRADO;
                document.getElementById('gradoSeleccionado').value = grado.NOMBRE_GRADO;
                document.getElementById('gradoId').value = grado.ID_GRADO;
                document.getElementById('nivelGrado').value = `Nivel ${grado.NIVEL_GRADO}`;
                document.getElementById('nivelId').value = grado.NIVEL_GRADO;
                
                // Información de carrera
                const carrera = grado.DESCRIPCION_CARRERA || 'Educación Básica';
                document.getElementById('carreraGrado').value = carrera;
                document.getElementById('carreraId').value = grado.IDENTIFICADOR_CARRERA_ESTUDIANTIL || '';
            }
        },
        error: function(error) {
            console.error('Error al cargar información del grado:', error);
        }
    });
}

// Cargar alumnos asignados al grado
function cargarAlumnosAsignados(page = 1) {
    if (!urlParams.periodo || !urlParams.grado) {
        $('#tablaAlumnos tbody').html('<tr><td colspan="6" class="text-center">Parámetros de URL no válidos</td></tr>');
        return;
    }
    
    const filtros = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_GRADO: urlParams.grado
    };
    
    $.ajax({
        url: `${apiBaseUrl}/alumnos-grado/filtrar?page=${page}&limit=10`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(filtros),
        success: function(response) {
            const data = response.data || [];
            const pagination = response.pagination;
            
            if (pagination) {
                currentPage = pagination.currentPage;
                totalPages = pagination.totalPages;
                // Actualizar contador
                $('#totalAlumnos').text(pagination.total);
            }
            
            const tbody = $('#tablaAlumnos tbody');
            tbody.empty();
            
            if (data.length === 0) {
                tbody.append('<tr><td colspan="6" class="text-center">No hay alumnos asignados a este grado</td></tr>');
            } else {
                data.forEach(alumno => {
                    const fila = `
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="student-avatar me-2" style="width: 30px; height: 30px; font-size: 0.8rem;">
                                        ${alumno.NOMBRE_ALUMNO.charAt(0).toUpperCase()}
                                    </div>
                                    @${alumno.PERFIL_PERSONA}
                                </div>
                            </td>
                            <td class="text-start">
                                <strong>${alumno.NOMBRE_ALUMNO}</strong>
                            </td>
                            <td>${alumno.NOMBRE_GRADO}</td>
                            <td>
                                <span class="badge bg-success text-white">
                                    Asignado
                                </span>
                            </td>
                            <td>${formatDate(alumno.FECHA_INGRESA_REGISTRO)}</td>
                            <td>
                                <button class="btn btn-danger btn-sm btn-eliminar" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deleteModal"
                                        data-id="${alumno.ID_ALUMNO}"
                                        data-nombre="${alumno.NOMBRE_ALUMNO}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.append(fila);
                });
            }
            
            actualizarPaginacion();
        },
        error: function(error) {
            console.error('Error al cargar alumnos asignados:', error);
            $('#tablaAlumnos tbody').html('<tr><td colspan="6" class="text-center text-danger">Error al cargar datos</td></tr>');
        }
    });
}

// Cargar todos los alumnos disponibles (sin filtro de nombre)
function cargarTodosLosAlumnos() {
    if (!gradoInfo) {
        console.error('Información del grado no disponible');
        return;
    }
    
    const resultadosContainer = $('#resultadosAlumnos');
    resultadosContainer.html(`
        <div class="text-center py-3">
            <div class="loading-spinner"></div>
            <p>Cargando alumnos disponibles...</p>
        </div>
    `);
    
    const datos = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_CARRERA: gradoInfo.IDENTIFICADOR_CARRERA_ESTUDIANTIL,
        NIVEL: gradoInfo.NIVEL_GRADO
    };
    
    $.ajax({
        url: `${apiBaseUrl}/alumnos-grado/seleccion`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            todosLosAlumnos = response.data || [];
            mostrarResultadosAlumnos(todosLosAlumnos);
        },
        error: function(error) {
            console.error('Error al cargar alumnos:', error);
            resultadosContainer.html(`
                <div class="text-center text-danger py-3">
                    <i class="fas fa-exclamation-triangle fa-2x mb-2"></i>
                    <p>Error al cargar alumnos. Intente nuevamente.</p>
                </div>
            `);
        }
    });
}

// Buscar alumnos disponibles (ahora filtra localmente)
function buscarAlumnos(nombre = '') {
    if (nombre.trim() === '') {
        // Si no hay filtro, mostrar todos
        mostrarResultadosAlumnos(todosLosAlumnos);
    } else {
        // Filtrar localmente
        const alumnosFiltrados = todosLosAlumnos.filter(alumno => 
            alumno.NOMBRE_COMPLETO.toLowerCase().includes(nombre.toLowerCase())
        );
        mostrarResultadosAlumnos(alumnosFiltrados);
    }
}

// Mostrar resultados de búsqueda de alumnos
function mostrarResultadosAlumnos(alumnos) {
    const container = $('#resultadosAlumnos');
    
    if (alumnos.length === 0) {
        container.html(`
            <div class="text-center text-muted py-4">
                <i class="fas fa-user-slash fa-2x mb-2"></i>
                <p>No se encontraron alumnos disponibles</p>
            </div>
        `);
        return;
    }
    
    let html = '';
    alumnos.forEach(alumno => {
        const statusClass = getStatusClass(alumno.ESTADO_RESULTADO);
        const statusText = getStatusText(alumno.ESTADO_RESULTADO);
        
        html += `
            <div class="student-card" data-alumno-id="${alumno.ID_ALUMNO}" data-alumno-info='${JSON.stringify(alumno)}'>
                <div class="d-flex align-items-center">
                    <div class="student-avatar me-3">
                        ${alumno.NOMBRE_COMPLETO.charAt(0).toUpperCase()}
                    </div>
                    <div class="student-info flex-grow-1">
                        <h6>${alumno.NOMBRE_COMPLETO}</h6>
                        <small class="text-muted">@${alumno.PERFIL_PERSONA}</small>
                        <div class="mt-1">
                            <small class="text-muted">Grado anterior: ${alumno.NOMBRE_GRADO}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <span class="status-badge ${statusClass}">
                            ${statusText}
                        </span>
                    </div>
                </div>
            </div>
        `;
    });
    
    container.html(html);
    
    // Agregar event listeners para selección
    $('.student-card').on('click', function() {
        $('.student-card').removeClass('selected');
        $(this).addClass('selected');
        
        const alumnoId = $(this).data('alumno-id');
        const alumnoInfo = $(this).data('alumno-info');
        
        seleccionarAlumno(alumnoId, alumnoInfo);
    });
}

// Seleccionar alumno
function seleccionarAlumno(alumnoId, alumnoInfo) {
    alumnoSeleccionado = alumnoInfo;
    
    $('#alumnoIdSeleccionado').val(alumnoId);
    $('#infoAlumnoSeleccionado').html(`
        <strong>${alumnoInfo.NOMBRE_COMPLETO}</strong><br>
        <small class="text-muted">@${alumnoInfo.PERFIL_PERSONA} - ${alumnoInfo.NOMBRE_GRADO}</small>
    `);
    
    $('#alumnoSeleccionado').show();
    $('#btnGuardar').prop('disabled', false);
}

// Funciones auxiliares
function getStatusClass(estado) {
    switch(estado) {
        case 'G': return 'status-ganado';
        case 'P': return 'status-perdido';
        case 'N': return 'status-nuevo';
        default: return 'bg-secondary text-white';
    }
}

function getStatusText(estado) {
    switch(estado) {
        case 'G': return 'Ganó';
        case 'P': return 'Perdió';
        case 'N': return 'Nuevo';
        default: return 'Desconocido';
    }
}

function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric' 
    });
}

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
                    <a class="page-link" href="#" data-page="${currentPage - 1}">Anterior</a>
                </li>
    `;
    
    for (let i = 1; i <= totalPages; i++) {
        paginationHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }
    
    paginationHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}">Siguiente</a>
                </li>
            </ul>
        </nav>
    `;
    
    paginationContainer.html(paginationHTML);
    
    $('.page-link').on('click', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page >= 1 && page <= totalPages) {
            cargarAlumnosAsignados(page);
        }
    });
}

function showError(message) {
    const errorContainer = document.getElementById("errorMessageContainer");
    const errorMessageElement = document.getElementById("errorMessage");
    errorMessageElement.textContent = message;
    errorContainer.classList.remove("d-none");
}

function hideError() {
    const errorContainer = document.getElementById('errorMessageContainer');
    errorContainer.classList.add('d-none');
}

// Inicialización
$(document).ready(function() {
    // Verificar parámetros de URL
    if (!urlParams.periodo || !urlParams.grado) {
        alert('URL no válida. Debe acceder desde /alumnos/{periodo}/{grado}');
        return;
    }
    
    // Cargar información inicial
    cargarInfoPeriodoGrado();
    cargarAlumnosAsignados();
    
    // Event listeners
    $('#btnBuscar').on('click', function() {
        const nombre = $('#buscarAlumno').val().trim();
        buscarAlumnos(nombre);
    });
    
    $('#buscarAlumno').on('keyup', function() {
        const nombre = $(this).val().trim();
        buscarAlumnos(nombre);
    });
    
    $('#buscarAlumno').on('keypress', function(e) {
        if (e.which === 13) { // Enter key
            const nombre = $(this).val().trim();
            buscarAlumnos(nombre);
        }
    });
    
    // Botón agregar - MODIFICADO para cargar alumnos automáticamente
    $('#agregar').on('click', function() {
        hideError();
        alumnoSeleccionado = null;
        $('#alumnoIdSeleccionado').val('');
        $('#alumnoSeleccionado').hide();
        $('#btnGuardar').prop('disabled', true);
        $('#buscarAlumno').val('');
        
        // Cargar todos los alumnos automáticamente cuando se abre el modal
        if (gradoInfo) {
            cargarTodosLosAlumnos();
        }
    });
    
    // Event listener para cuando el modal se muestra completamente
    $('#asignacionModal').on('shown.bs.modal', function() {
        // Si no se han cargado los alumnos aún, cargarlos
        if (todosLosAlumnos.length === 0 && gradoInfo) {
            cargarTodosLosAlumnos();
        }
    });
    
    // Botón guardar
    $('#btnGuardar').on('click', function() {
        if (!alumnoSeleccionado) {
            showError('Debe seleccionar un alumno');
            return;
        }
        
        const datos = {
            ID_PERIODO_ESCOLAR: urlParams.periodo,
            ID_ALUMNO: parseInt($('#alumnoIdSeleccionado').val()),
            ID_GRADO: urlParams.grado,
            ID_PERSONA_INGRESO: ID_PERSONA,
            ACCION: 'I'
        };
        
        $.ajax({
            url: `${apiBaseUrl}/alumnos-grado`,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datos),
            success: function(response) {
                if (response.mensaje === "" || !response.mensaje) {
                    $('#asignacionModal').modal('hide');
                    cargarAlumnosAsignados(currentPage);
                    // Limpiar la lista para que se recargue la próxima vez
                    todosLosAlumnos = [];
                } else {
                    showError(response.mensaje);
                }
            },
            error: function(error) {
                console.error('Error al asignar alumno:', error);
                showError('Ocurrió un error al asignar el alumno. Intente nuevamente.');
            }
        });
    });
    
    // Botón eliminar
    $(document).on('click', '.btn-eliminar', function() {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        $('#CodigoEliminar').text(id);
        $('#DescripcionEliminar').text(nombre);
        $('#ideliminacion').val(id);
    });
    
    // Confirmar eliminación
    $('#btnConfirmDelete').on('click', function() {
        const alumnoId = parseInt($('#ideliminacion').val());
        
        const datos = {
            ID_PERIODO_ESCOLAR: urlParams.periodo,
            ID_ALUMNO: alumnoId,
            ID_GRADO: urlParams.grado,
            ID_PERSONA_INGRESO: ID_PERSONA,
            ACCION: 'D'
        };
        
        $.ajax({
            url: `${apiBaseUrl}/alumnos-grado`,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datos),
            success: function(response) {
                if (response.mensaje === "" || !response.mensaje) {
                    $('#deleteModal').modal('hide');
                    cargarAlumnosAsignados(currentPage);
                    // Limpiar la lista para que se recargue la próxima vez
                    todosLosAlumnos = [];
                } else {
                    showError(response.mensaje);
                }
            },
            error: function(error) {
                console.error('Error al remover alumno:', error);
                alert('Ocurrió un error al remover el alumno. Intente nuevamente.');
            }
        });
    });
});
</script>
@endsection
