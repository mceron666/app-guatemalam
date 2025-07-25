@extends("layouts.header")
@section("contenido")
<link href="/css/modal.css" rel="stylesheet">

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-chart-line"></i>
        <span>Notas del Alumno</span>
    </div>
</div>

<!-- Nueva sección de información del alumno -->
<div class="container-fluid mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="d-flex align-items-center">
                        <div class="me-4">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5 class="mb-1 fw-bold" id="alumno-nombre-completo">Cargando información del alumno...</h5>
                            <p class="mb-0 text-muted">
                                <span id="alumno-grado">-</span> | 
                                <span id="alumno-correo">-</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="d-flex flex-column align-items-md-end">
                        <span class="text-muted small">Estado de Solvencia</span>
                        <h4 class="mb-0 fw-bold" id="diferencia-solvencia">
                            <i class="fas fa-spinner fa-spin"></i> Cargando...
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <!-- Selector de período -->
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-calendar-alt text-muted"></i>
                        </span>
                        <select id="filtroPeriodo" class="form-select">
                            <option value="">Seleccione un período...</option>
                            <!-- Se llenará dinámicamente -->
                        </select>
                    </div>
                </div>
            </div>
            <!-- Grid de Notas -->
            <div class="table-responsive">
                <div class="notas-grid">
                    <div class="notas-header">
                        <div class="materia-header">Materia</div>
                        <div id="bloque-1" class="bloque-header">Primer bloque</div>
                        <div id="bloque-2" class="bloque-header">Segundo bloque</div>
                        <div id="bloque-3" class="bloque-header">Tercer bloque</div>
                        <div id="bloque-4" class="bloque-header">Cuarto bloque</div>
                    </div>
                    <div id="notas-body" class="notas-body">
                        <div class="loading-message">Cargando notas...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notas-grid {
    min-width: 800px;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    overflow: hidden;
}

.notas-header {
    display: grid;
    grid-template-columns: 250px 1fr 1fr 1fr 1fr;
    background-color: #198754;
    color: white;
}

.materia-header {
    padding: 15px;
    text-align: center;
    font-weight: bold;
    border-right: 1px solid rgba(255,255,255,0.2);
    background-color: #198754;
}

.bloque-header {
    padding: 15px;
    text-align: center;
    font-weight: bold;
    border-right: 1px solid rgba(255,255,255,0.2);
    background-color: #198754;
}

.notas-body {
    display: grid;
    grid-template-columns: 250px 1fr 1fr 1fr 1fr;
}

.loading-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-style: italic;
}

.materia-slot {
    padding: 15px;
    text-align: center;
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    font-weight: 500;
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 70px;
    font-size: 0.9rem;
    color: white;
}

.nota-cell {
    border-right: 1px solid #dee2e6;
    border-bottom: 1px solid #dee2e6;
    min-height: 70px;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #f8f9fa;
}

.nota-value {
    font-size: 1.2rem;
    font-weight: bold;
    color: #198754;
}

.nota-empty {
    color: #6c757d;
    font-style: italic;
    font-size: 0.9rem;
}
</style>

<script>
// Obtener parámetros de la URL
function getUrlParameters() {
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Buscar el índice de 'notas-alumnos' en la URL
    const notasIndex = segments.indexOf('notas-alumnos');
    
    if (notasIndex !== -1 && segments.length > notasIndex + 1) {
        return {
            alumno: parseInt(segments[notasIndex + 1])
        };
    }
    
    return { alumno: null };
}

// Variables globales
let urlParams = getUrlParameters();
const ID_ALUMNO = urlParams.alumno;
const periodosApiUrl = `http://localhost:3000/periodos/alumno/${ID_ALUMNO}`;
let selectedPeriodoId = null;
let notasData = null;
let periodosData = [];

// Cargar información del alumno
function cargarInfoAlumno() {
    if (!ID_ALUMNO) {
        console.error('ID de alumno no válido');
        return;
    }
    
    const datos = {
        ID_ALUMNO: ID_ALUMNO
    };
    
    $.ajax({
        url: 'http://localhost:3000/alumnos-grado/lista',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            if (response.data && response.data.length > 0) {
                const alumno = response.data[0];
                
                // Actualizar información del alumno
                document.getElementById('alumno-nombre-completo').textContent = alumno.NOMBRE_COMPLETO;
                document.getElementById('alumno-grado').textContent = alumno.NOMBRE_GRADO;
                document.getElementById('alumno-correo').textContent = alumno.CORREO_PERSONA;
                
                // Mostrar diferencia de solvencia con colores
                const diferenciaSolvencia = parseFloat(alumno.DIFERENCIA_SOLVENCIA);
                const elementoSolvencia = document.getElementById('diferencia-solvencia');
                
                if (diferenciaSolvencia < 0) {
                    // Debe dinero - color rojizo
                    elementoSolvencia.innerHTML = `<i class="fas fa-exclamation-triangle me-2"></i>Q ${Math.abs(diferenciaSolvencia).toFixed(2)}`;
                    elementoSolvencia.className = 'mb-0 fw-bold text-danger';
                    elementoSolvencia.title = 'El alumno tiene saldo pendiente';
                } else if (diferenciaSolvencia > 0) {
                    // Tiene saldo a favor - color verde
                    elementoSolvencia.innerHTML = `<i class="fas fa-check-circle me-2"></i>Q ${diferenciaSolvencia.toFixed(2)}`;
                    elementoSolvencia.className = 'mb-0 fw-bold text-success';
                    elementoSolvencia.title = 'El alumno tiene saldo a favor';
                } else {
                    // Está al día - color verde
                    elementoSolvencia.innerHTML = `<i class="fas fa-check-circle me-2"></i>Q 0.00`;
                    elementoSolvencia.className = 'mb-0 fw-bold text-success';
                    elementoSolvencia.title = 'El alumno está al día con sus pagos';
                }
            } else {
                document.getElementById('alumno-nombre-completo').textContent = 'Alumno no encontrado';
                document.getElementById('diferencia-solvencia').innerHTML = '<i class="fas fa-times-circle me-2"></i>Error';
                document.getElementById('diferencia-solvencia').className = 'mb-0 fw-bold text-warning';
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar información del alumno:', error);
            document.getElementById('alumno-nombre-completo').textContent = 'Error al cargar información';
            document.getElementById('diferencia-solvencia').innerHTML = '<i class="fas fa-times-circle me-2"></i>Error';
            document.getElementById('diferencia-solvencia').className = 'mb-0 fw-bold text-danger';
        }
    });
}

$(document).ready(function () {
    // Verificar que tenemos un ID de alumno válido
    if (!ID_ALUMNO || isNaN(ID_ALUMNO)) {
        console.error('ID de alumno no válido en la URL');
        $('#notas-body').html('<div class="loading-message">Error: ID de alumno no válido</div>');
        alert('URL no válida. Debe acceder desde /notas-alumnos/{id_alumno}');
        return;
    }
    
    console.log('ID_ALUMNO obtenido de la URL:', ID_ALUMNO);
    
    // Cargar información inicial
    cargarInfoAlumno();
    cargarPeriodos();
});

// Función para cargar períodos
function cargarPeriodos() {
    $.ajax({
        url: periodosApiUrl,
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            periodosData = data;
            populatePeriodosDropdown(data);
            
            // Seleccionar automáticamente el período más reciente
            if (data.length > 0) {
                const periodoMasReciente = data[0]; // Asumiendo que vienen ordenados
                selectedPeriodoId = periodoMasReciente.ID_PERIODO_ESCOLAR;
                $('#filtroPeriodo').val(selectedPeriodoId);
                cargarNotas();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar períodos:', error);
            $('#notas-body').html('<div class="loading-message">Error al cargar períodos</div>');
        }
    });
}

// Función para llenar el dropdown de períodos
function populatePeriodosDropdown(periodos) {
    const dropdown = $('#filtroPeriodo');
    
    // Limpiar opciones existentes excepto la primera
    dropdown.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(periodos, function(index, periodo) {
        dropdown.append($('<option>', {
            value: periodo.ID_PERIODO_ESCOLAR,
            text: periodo.NOMBRE_PERIODO
        }));
    });
    
    // Event listener para el cambio de período
    dropdown.off('change').on('change', function() {
        selectedPeriodoId = $(this).val();
        console.log('Período seleccionado:', selectedPeriodoId);
        
        if (selectedPeriodoId) {
            cargarNotas();
        } else {
            limpiarGrid();
        }
    });
}

// Función para cargar notas
function cargarNotas() {
    if (!ID_ALUMNO || !selectedPeriodoId) {
        console.error('Faltan parámetros: ID_ALUMNO o período');
        return;
    }
    
    const notasBody = $('#notas-body');
    notasBody.html('<div class="loading-message">Cargando notas...</div>');
    
    const apiNotasUrl = `http://localhost:3000/notas/administracion/${ID_ALUMNO}/${selectedPeriodoId}`;
    
    $.ajax({
        url: apiNotasUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            notasData = response;
            console.log('Notas cargadas:', notasData);
            renderNotasGrid();
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar notas:', error);
            const notasBody = $('#notas-body');
            notasBody.html('<div class="loading-message">Error al cargar las notas</div>');
        }
    });
}

// Función para renderizar el grid de notas
function renderNotasGrid() {
    if (!notasData || !notasData.materias || !notasData.bloques) {
        console.error('Datos de notas no válidos');
        return;
    }
    
    // Actualizar headers de bloques con información real
    actualizarHeadersBloques(notasData.bloques);
    
    // Renderizar cuerpo de notas
    renderNotasBody(notasData.bloques);
}

// Función para actualizar headers de bloques
function actualizarHeadersBloques(bloques) {
    // Actualizar headers con los nombres reales de los bloques
    for (let i = 0; i < Math.min(bloques.length, 4); i++) {
        const bloque = bloques[i];
        const headerElement = $(`#bloque-${i + 1}`);
        
        if (bloque) {
            headerElement.text(bloque.nombreBloque);
        }
    }
}

// Función para renderizar el cuerpo de notas
function renderNotasBody(bloques) {
    const notasBody = $('#notas-body');
    notasBody.empty();
    
    // Renderizar cada materia
    notasData.materias.forEach(materia => {
        // Celda de materia
        const materiaSlot = $(`
            <div class="materia-slot" style="background-color: ${materia.COLOR_MATERIA}; color: ${materia.USA_LETRAS_BLANCAS === 'Y' ? 'white' : 'black'};">
                <div>
                    <div style="font-weight: bold;">${materia.NOMBRE_MATERIA}</div>
                    <small>Materia ${materia.NUMERO}</small>
                </div>
            </div>
        `);
        
        notasBody.append(materiaSlot);
        
        // Celdas de notas para cada bloque (máximo 4)
        for (let i = 0; i < Math.min(bloques.length, 4); i++) {
            const bloque = bloques[i];
            const notaCell = $('<div class="nota-cell"></div>');
            
            // Buscar la nota para esta materia en este bloque
            const nota = encontrarNotaPorMateria(bloque.notas, materia.NUMERO);
            
            if (nota && nota.TOTAL > 0) {
                notaCell.html(`<div class="nota-value">${nota.TOTAL}</div>`);
            } else {
                notaCell.html('<div class="nota-empty">Sin nota</div>');
            }
            
            notasBody.append(notaCell);
        }
        
        // Si hay menos de 4 bloques, llenar con celdas vacías
        for (let i = bloques.length; i < 4; i++) {
            const notaCell = $('<div class="nota-cell"></div>');
            notaCell.html('<div class="nota-empty">-</div>');
            notasBody.append(notaCell);
        }
    });
}

// Función para encontrar nota por número de materia
function encontrarNotaPorMateria(notas, numeroMateria) {
    if (!notas || notas.length === 0) {
        return null;
    }
    return notas.find(nota => nota.NUMERO === numeroMateria);
}

// Función para limpiar el grid
function limpiarGrid() {
    $('#notas-body').html('<div class="loading-message">Seleccione un período para ver las notas...</div>');
}
</script>
@endsection
