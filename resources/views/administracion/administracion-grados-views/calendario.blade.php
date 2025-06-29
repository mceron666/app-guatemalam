@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-calendar-alt"></i>
        <span>Calendario Escolar</span>  
        <div class="font-size: 20px; margin-top: 10px;">
            Período: <span id="header-periodo-codigo" style="font-weight: 500;">Cargando...</span> |
            Grado: <span id="header-grado-nombre" style="font-weight: 500;">Cargando...</span>
        </div>                  
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <!-- Calendario Grid -->
            <div class="table-responsive">
                <div class="calendar-grid">
                    <div class="calendar-header">
                        <div class="time-header">Hora</div>
                        <div class="day-header">Lunes</div>
                        <div class="day-header">Martes</div>
                        <div class="day-header">Miércoles</div>
                        <div class="day-header">Jueves</div>
                        <div class="day-header">Viernes</div>
                    </div>
                    <div id="calendar-body" class="calendar-body">
                        <div class="loading-message">Cargando calendario...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para agregar/editar entrada -->
<div class="modal fade custom-modal" id="calendarioModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header text-white" style="background-color: #198754;">
                <div class="d-flex align-items-center">
                    <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
                    <h4 class="modal-title" id="titulo">Agregar Entrada al Calendario</h4>
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
                <form id="calendarioForm">
                    <input type="hidden" id="calendarioId" name="ID_CALENDARIO">
                    <input type="hidden" id="periodoId" name="ID_PERIODO_ESCOLAR">
                    <input type="hidden" id="gradoId" name="ID_GRADO">
                    <input type="hidden" id="diaSeleccionado" name="DIA_DE_LA_SEMANA">
                    <input type="hidden" id="horarioSeleccionado" name="CODIGO_HORARIO">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Información Fija</h5>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Período Escolar</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" class="form-control" id="periodoSeleccionado" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Grado</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                                            <input type="text" class="form-control" id="gradoSeleccionado" readonly>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="diaDisplay" class="form-label fw-semibold">Día de la Semana</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-calendar-day"></i></span>
                                            <input type="text" class="form-control" id="diaDisplay" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="horarioDisplay" class="form-label fw-semibold">Horario</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-clock"></i></span>
                                            <input type="text" class="form-control" id="horarioDisplay" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Entrada del Calendario</h5>

                                    <div class="mb-3">
                                        <label for="selectTipo" class="form-label fw-semibold">Tipo</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-list"></i></span>
                                            <select class="form-select" id="selectTipo" name="ES_RECREO">
                                                <option value="N">Clase Regular</option>
                                                <option value="Y">Recreo</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3" id="materiaContainer">
                                        <label for="selectMateria" class="form-label fw-semibold">Materia</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-book"></i></span>
                                            <select class="form-select" id="selectMateria" name="ID_MATERIA">
                                                <option value="" selected disabled>Seleccione una materia</option>
                                                <!-- Options will be populated dynamically -->
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-lg px-4" data-bs-dismiss="modal">
                    <i class="bi bi-x-circle me-2"></i>Cancelar
                </button>
                <button type="button" class="btn btn-success btn-lg px-4" id="btnGuardar">
                    <i class="bi bi-check-circle me-2"></i>Guardar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.calendar-grid {
    min-width: 800px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

.calendar-header {
    display: grid;
    grid-template-columns: 150px repeat(5, 1fr);
    background-color: #198754;
    color: white;
}

.time-header, .day-header {
    padding: 15px;
    text-align: center;
    font-weight: bold;
    border-right: 1px solid rgba(255,255,255,0.2);
}

.calendar-body {
    display: grid;
    grid-template-columns: 150px repeat(5, 1fr);
}

.loading-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-style: italic;
}

.time-slot {
    padding: 10px;
    text-align: center;
    background-color: #f8f9fa;
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 70px;
    font-size: 0.9rem;
}

.calendar-cell {
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    min-height: 70px;
    position: relative;
    cursor: pointer;
    transition: background-color 0.2s;
}

.calendar-cell:hover {
    background-color: #f8f9fa;
}

.calendar-entry {
    height: 100%;
    padding: 8px;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

.calendar-entry.recreo {
    background-color: #fff3cd;
    border-left: 4px solid #ffc107;
    color: #856404;
}

.calendar-entry.materia {
    border-left: 4px solid;
    font-weight: 500;
}

.entry-actions {
    position: absolute;
    top: 5px;
    right: 5px;
    opacity: 0;
    transition: opacity 0.2s;
}

.calendar-entry:hover .entry-actions {
    opacity: 1;
}

.entry-subject {
    font-size: 0.85rem;
    font-weight: bold;
    text-align: center;
}

.add-entry {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #6c757d;
    font-size: 1.5rem;
}

.add-entry:hover {
    color: #198754;
    background-color: #f8f9fa;
}

.empty-cell {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #6c757d;
    font-size: 0.9rem;
    font-style: italic;
}

.empty-cell:hover {
    background-color: #e3f2fd;
    color: #1976d2;
}

.cell-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #6c757d;
    font-size: 0.8rem;
}
</style>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    
const apiBaseUrl = 'http://localhost:3000/calendario';

// Días de la semana
const daysOfWeek = [
    { id: 1, name: 'Lunes' },
    { id: 2, name: 'Martes' },
    { id: 3, name: 'Miércoles' },
    { id: 4, name: 'Jueves' },
    { id: 5, name: 'Viernes' }
];

// Obtener parámetros de la URL
function getUrlParameters() {
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Buscar el índice de 'calendario' en la URL
    const calendarioIndex = segments.indexOf('calendario');
    
    if (calendarioIndex !== -1 && segments.length > calendarioIndex + 2) {
        return {
            periodo: parseInt(segments[calendarioIndex + 1]),
            grado: parseInt(segments[calendarioIndex + 2])
        };
    }
    
    return { periodo: null, grado: null };
}

// Variables globales
let urlParams = getUrlParameters();
let horariosData = [];
let materiasData = [];
let periodoInfo = null;
let gradoInfo = null;
let currentEditingEntry = null;

// Cargar información del período y grado
function cargarInfoPeriodoGrado() {
    if (!urlParams.periodo || !urlParams.grado) {
        console.error('Parámetros de URL no válidos');
        return;
    }
    
    // Cargar información del período
    axios.get('http://localhost:3000/periodos/seleccion')
        .then(response => {
            const periodos = response.data;
            const periodo = periodos.find(p => p.ID_PERIODO_ESCOLAR == urlParams.periodo);
            if (periodo) {
                periodoInfo = periodo;
                document.getElementById('header-periodo-codigo').textContent = periodo.CODIGO_PERIODO;
            }
        })
        .catch(error => {
            console.error('Error al cargar información del período:', error);
        });
    
    // Cargar información del grado
    const gradoId = urlParams.grado;
    $.ajax({
        url: `http://localhost:3000/grados/${gradoId}/i`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const grado = response.data[0];
            if (grado) {
                gradoInfo = grado;
                document.getElementById('header-grado-nombre').textContent = grado.NOMBRE_GRADO;
            }
        },
        error: function(error) {
            console.error('Error al cargar información del grado:', error);
        }
    });
}

// Cargar horarios disponibles
function cargarHorarios() {
    if (!urlParams.periodo || !urlParams.grado) {
        console.error('Parámetros de URL no válidos');
        return;
    }
    
    const filtros = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_GRADO: urlParams.grado
    };
    
    $.ajax({
        url: `${apiBaseUrl}/filtrar`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(filtros),
        success: function(response) {
            horariosData = response.horarios || [];
            console.log('Horarios cargados:', horariosData);
            
            if (horariosData.length > 0) {
                renderCalendar();
            } else {
                console.error('No se recibieron horarios del servidor');
                showError('No se pudieron cargar los horarios');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar horarios:', { xhr, status, error });
            showError('Error al cargar los horarios: ' + error);
        }
    });
}

// Renderizar el calendario
function renderCalendar() {
    if (horariosData.length === 0) {
        console.log('No hay horarios para renderizar');
        return;
    }
    
    console.log('Iniciando renderizado del calendario');
    const calendarBody = document.getElementById('calendar-body');
    calendarBody.innerHTML = '';
    
    horariosData.forEach((horario) => {
        // Celda de hora
        const timeCell = document.createElement('div');
        timeCell.className = 'time-slot';
        timeCell.textContent = horario.DESCRIPCION_HORA;
        calendarBody.appendChild(timeCell);
        
        // Celdas de días
        daysOfWeek.forEach((day) => {
            const cell = document.createElement('div');
            cell.className = 'calendar-cell';
            cell.setAttribute('data-day', day.id);
            cell.setAttribute('data-horario', horario.CODIGO_HORARIO);
            
            // Mostrar loading inicialmente
            cell.innerHTML = '<div class="cell-loading">Cargando...</div>';
            
            // Cargar datos de esta celda específica
            loadCellData(cell, day.id, horario.CODIGO_HORARIO, horario.DESCRIPCION_HORA);
            
            calendarBody.appendChild(cell);
        });
    });
    
    console.log('Calendario renderizado completamente');
}

// Cargar datos de una celda específica
function loadCellData(cell, day, codigoHorario, descripcionHora) {
    const filtros = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_GRADO: urlParams.grado
    };
    
    $.ajax({
        url: `${apiBaseUrl}/filtrar/${day}/${codigoHorario}`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(filtros),
        success: function(response) {
            const entry = response.horarioSeleccionado;
            
            if (entry && (entry.ID_MATERIA || entry.ES_RECREO === 'Y')) {
                // Hay una entrada, renderizarla
                const entryId = `entry_${day}_${codigoHorario}`;
                cell.innerHTML = renderCalendarEntry(entry, entryId);
            } else {
                // Celda vacía
                cell.innerHTML = `<div class="empty-cell" onclick="openAddModal(${day}, ${codigoHorario}, '${descripcionHora.replace(/'/g, "\\'")}')">Hacer clic para agregar</div>`;
            }
        },
        error: function(xhr, status, error) {
            console.error(`Error al cargar celda ${day}-${codigoHorario}:`, error);
            // En caso de error, mostrar como celda vacía
            cell.innerHTML = `<div class="empty-cell" onclick="openAddModal(${day}, ${codigoHorario}, '${descripcionHora.replace(/'/g, "\\'")}')">Hacer clic para agregar</div>`;
        }
    });
}

// Renderizar entrada del calendario
function renderCalendarEntry(entry, entryId) {
    let html = '';
    
    if (entry.ES_RECREO === 'Y') {
        html = `
            <div class="calendar-entry recreo">
                <div class="entry-subject">
                    <i class="fas fa-coffee"></i> Recreo
                </div>
                <div class="entry-actions">
                    <button class="btn btn-sm btn-warning me-1" onclick="editEntryById('${entryId}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteEntryById('${entryId}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    } else {
        const backgroundColor = entry.COLOR_MATERIA || '#198754';
        // Determinar color del texto basado en USA_LETRAS_BLANCAS
        const textColor = entry.USA_LETRAS_BLANCAS === 'Y' ? 'white' : 'black';
        
        html = `
            <div class="calendar-entry materia" style="background-color: ${backgroundColor}; border-left-color: ${backgroundColor}; color: ${textColor};">
                <div class="entry-subject">
                    <i class="fas fa-book"></i> ${entry.NOMBRE_MATERIA || 'Materia'}
                </div>
                <div class="entry-actions">
                    <button class="btn btn-sm btn-warning me-1" onclick="editEntryById('${entryId}')">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-sm btn-danger" onclick="deleteEntryById('${entryId}')">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
        `;
    }
    
    return html;
}

// Obtener entrada específica para editar/eliminar
function getEntryForCell(day, codigoHorario, callback) {
    const filtros = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_GRADO: urlParams.grado
    };
    
    $.ajax({
        url: `${apiBaseUrl}/filtrar/${day}/${codigoHorario}`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(filtros),
        success: function(response) {
            callback(response.horarioSeleccionado);
        },
        error: function(xhr, status, error) {
            console.error(`Error al obtener entrada ${day}-${codigoHorario}:`, error);
            callback(null);
        }
    });
}

// Cargar materias
function cargarMaterias() {
    $.ajax({
        url: 'http://localhost:3000/materias',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            materiasData = response.data || [];
            populateMateriasDropdown(materiasData);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar las materias:', error);
        }
    });
}

// Llenar dropdown de materias
function populateMateriasDropdown(materias) {
    const selectMateria = $('#selectMateria');
    selectMateria.find('option:not(:first)').remove();
    
    $.each(materias, function(index, materia) {
        const option = $('<option>', {
            value: materia.ID_MATERIA,
            text: materia.NOMBRE_MATERIA,
            'data-color': materia.COLOR_MATERIA,
            'data-tipo': materia.TIPO_LETRA
        });
        selectMateria.append(option);
    });
}

// Obtener nombre del día
function getDayName(dayId) {
    const day = daysOfWeek.find(d => d.id == dayId);
    return day ? day.name : '';
}

// Obtener descripción del horario
function getHorarioDescription(codigoHorario) {
    const horario = horariosData.find(h => parseInt(h.CODIGO_HORARIO) === parseInt(codigoHorario));
    return horario ? horario.DESCRIPCION_HORA : '';
}

// Abrir modal para agregar
function openAddModal(day, codigoHorario, descripcionHora) {
    resetForm();
    currentEditingEntry = null;
    
    // Cargar información del período y grado en el modal
    if (periodoInfo) {
        $('#periodoSeleccionado').val(periodoInfo.DESCRIPCION_PERIODO);
        $('#periodoId').val(periodoInfo.ID_PERIODO_ESCOLAR);
    }
    
    if (gradoInfo) {
        $('#gradoSeleccionado').val(gradoInfo.NOMBRE_GRADO);
        $('#gradoId').val(gradoInfo.CODIGO_GRADO);
    }
    
    // Establecer día y horario
    $('#diaSeleccionado').val(day);
    $('#horarioSeleccionado').val(codigoHorario);
    $('#diaDisplay').val(getDayName(day));
    $('#horarioDisplay').val(descripcionHora);
    
    $('#titulo').text('Agregar Entrada al Calendario');
    $('#calendarioModal').modal('show');
}

// Editar entrada por ID
function editEntryById(entryId) {
    const [, dayId, codigoHorario] = entryId.split('_');
    
    getEntryForCell(parseInt(dayId), parseInt(codigoHorario), function(entry) {
        if (entry) {
            editEntry(entry);
        } else {
            console.error('No se encontró la entrada para editar');
        }
    });
}

// Eliminar entrada por ID
function deleteEntryById(entryId) {
    const [, dayId, codigoHorario] = entryId.split('_');
    
    getEntryForCell(parseInt(dayId), parseInt(codigoHorario), function(entry) {
        if (entry) {
            // Usar SweetAlert2 para confirmar eliminación
            Swal.fire({
                title: '¿Está seguro?',
                text: entry.ES_RECREO === 'Y' ? 
                    'Se eliminará el recreo de este horario' : 
                    `Se eliminará la materia "${entry.NOMBRE_MATERIA}" de este horario`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteEntry(entry);
                }
            });
        } else {
            console.error('No se encontró la entrada para eliminar');
        }
    });
}

// Editar entrada
function editEntry(entry) {
    console.log('Editando entrada:', entry);
    resetForm();
    currentEditingEntry = entry;
    
    // Cargar información del período y grado en el modal
    if (periodoInfo) {
        $('#periodoSeleccionado').val(periodoInfo.DESCRIPCION_PERIODO);
        $('#periodoId').val(periodoInfo.ID_PERIODO_ESCOLAR);
    }
    
    if (gradoInfo) {
        $('#gradoSeleccionado').val(gradoInfo.NOMBRE_GRADO);
        $('#gradoId').val(gradoInfo.CODIGO_GRADO);
    }
    
    // Establecer valores de la entrada
    $('#calendarioId').val(entry.ID_CALENDARIO || '');
    $('#diaSeleccionado').val(entry.DIA_DE_LA_SEMANA);
    $('#horarioSeleccionado').val(entry.CODIGO_HORARIO);
    $('#diaDisplay').val(getDayName(entry.DIA_DE_LA_SEMANA));
    
    // Usar DESCRIPCION_HORA del entry si está disponible, sino usar la función
    const descripcionHora = entry.DESCRIPCION_HORA || getHorarioDescription(entry.CODIGO_HORARIO);
    $('#horarioDisplay').val(descripcionHora);
    
    // Establecer tipo (recreo o materia)
    const esRecreo = entry.ES_RECREO === 'Y';
    $('#selectTipo').val(esRecreo ? 'Y' : 'N');
    
    // Si no es recreo y tiene materia, seleccionarla
    if (!esRecreo && entry.ID_MATERIA) {
        $('#selectMateria').val(entry.ID_MATERIA);
    }
    
    toggleMateriaField();
    $('#titulo').text('Modificar Entrada del Calendario');
    $('#calendarioModal').modal('show');
}

// Eliminar entrada
function deleteEntry(entry) {
    const datos = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_GRADO: urlParams.grado,
        ID_MATERIA: entry.ID_MATERIA,
        DIA_DE_LA_SEMANA: entry.DIA_DE_LA_SEMANA,
        CODIGO_HORARIO: entry.CODIGO_HORARIO,
        ES_RECREO: entry.ES_RECREO,
        ACCION: 'D',
        ID_PERSONA_INGRESO: ID_PERSONA
    };
    
    $.ajax({
        url: apiBaseUrl,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(datos),
        success: function(response) {
            if (response.mensaje === "") {
                // Mostrar mensaje de éxito
                Swal.fire({
                    title: '¡Eliminado!',
                    text: 'La entrada ha sido eliminada correctamente.',
                    icon: 'success',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                // Recargar solo la celda afectada
                const cell = document.querySelector(`[data-day="${entry.DIA_DE_LA_SEMANA}"][data-horario="${entry.CODIGO_HORARIO}"]`);
                if (cell) {
                    const descripcionHora = getHorarioDescription(entry.CODIGO_HORARIO);
                    loadCellData(cell, entry.DIA_DE_LA_SEMANA, entry.CODIGO_HORARIO, descripcionHora);
                }
            } else {
                Swal.fire({
                    title: 'Error',
                    text: response.mensaje,
                    icon: 'error'
                });
            }
        },
        error: function(err) {
            console.error(err);
            Swal.fire({
                title: 'Error',
                text: 'Ocurrió un error al eliminar la entrada.',
                icon: 'error'
            });
        }
    });
}

// Mostrar/ocultar campo de materia según el tipo
function toggleMateriaField() {
    const esRecreo = $('#selectTipo').val();
    const materiaContainer = $('#materiaContainer');
    
    if (esRecreo === 'Y') {
        materiaContainer.hide();
        $('#selectMateria').val('');
    } else {
        materiaContainer.show();
    }
}

// Resetear formulario
function resetForm() {
    $('#calendarioForm')[0].reset();
    $('#calendarioId').val('');
    $('#diaSeleccionado').val('');
    $('#horarioSeleccionado').val('');
    $('#diaDisplay').val('');
    $('#horarioDisplay').val('');
    $('#selectTipo').val('N');
    $('#selectMateria').val('');
    toggleMateriaField();
    hideError();
}

// Mostrar error
function showError(message) {
    const errorContainer = document.getElementById("errorMessageContainer");
    const errorMessageElement = document.getElementById("errorMessage");
    errorMessageElement.textContent = message;
    errorContainer.classList.remove("d-none");
}

// Ocultar error
function hideError() {
    const errorContainer = document.getElementById('errorMessageContainer');
    errorContainer.classList.add('d-none');
}

// Inicialización
$(document).ready(function() {
    // Verificar parámetros de URL
    if (!urlParams.periodo || !urlParams.grado) {
        alert('URL no válida. Debe acceder desde /calendario/{periodo}/{grado}');
        return;
    }
    
    // Cargar datos iniciales
    cargarInfoPeriodoGrado();
    cargarHorarios(); // Esto iniciará el renderizado del calendario
    cargarMaterias();
    
    // Event listeners
    $('#selectTipo').change(toggleMateriaField);
    
    // Botón guardar
    $("#btnGuardar").click(function() {
        const titulo = $("#titulo").text().trim();
        const accion = titulo === "Agregar Entrada al Calendario" ? "I" : "U";
        
        // Validaciones
        if ($('#selectTipo').val() === 'N' && !$('#selectMateria').val()) {
            showError('Debe seleccionar una materia para clases regulares');
            return;
        }
        
        if ($('#selectTipo').val() === 'Y' && $('#selectMateria').val()) {
            showError('No puede asignar materia durante el recreo');
            return;
        }
        
        const datos = {
            ID_PERIODO_ESCOLAR: urlParams.periodo,
            ID_GRADO: urlParams.grado,
            ID_MATERIA: $('#selectTipo').val() === 'Y' ? null : parseInt($('#selectMateria').val()),
            DIA_DE_LA_SEMANA: parseInt($('#diaSeleccionado').val()),
            CODIGO_HORARIO: parseInt($('#horarioSeleccionado').val()),
            ES_RECREO: $('#selectTipo').val(),
            ACCION: accion,
            ID_PERSONA_INGRESO: ID_PERSONA
        };
        
        console.log('Enviando datos:', datos);
        
        $.ajax({
            url: apiBaseUrl,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            success: function(response) {
                if (response.mensaje === "") {
                    $("#calendarioModal").modal("hide");
                    
                    // Mostrar mensaje de éxito
                    Swal.fire({
                        title: '¡Guardado!',
                        text: accion === 'I' ? 'Entrada agregada correctamente.' : 'Entrada modificada correctamente.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    });
                    
                    // Recargar solo la celda afectada
                    const cell = document.querySelector(`[data-day="${datos.DIA_DE_LA_SEMANA}"][data-horario="${datos.CODIGO_HORARIO}"]`);
                    if (cell) {
                        const descripcionHora = getHorarioDescription(datos.CODIGO_HORARIO);
                        loadCellData(cell, datos.DIA_DE_LA_SEMANA, datos.CODIGO_HORARIO, descripcionHora);
                    }
                } else {
                    showError(response.mensaje);
                }
            },
            error: function(err) {
                console.error(err);
                showError("Ocurrió un error en la solicitud. Por favor intente nuevamente.");
            }
        });
    });
});
</script>
@endsection