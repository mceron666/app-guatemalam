@extends("layouts.alumnos")

@section("contenido")

<link href="/css/modal.css" rel="stylesheet">

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-chart-line"></i>
        <span>Notas del Alumno</span>
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
                        <div id="bloque-1" class="bloque-header solvente">Primer bloque</div>
                        <div id="bloque-2" class="bloque-header no-solvente">Segundo bloque</div>
                        <div id="bloque-3" class="bloque-header no-solvente">Tercer bloque</div>
                        <div id="bloque-4" class="bloque-header no-solvente">Cuarto bloque</div>
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

.bloque-header.no-solvente {
    background-color: #dc3545;
    position: relative;
}

.bloque-header.no-solvente::after {
    content: " 🔒";
    font-size: 0.8rem;
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

.bloque-no-solvente {
    background-color: #f8d7da;
    color: #721c24;
    position: relative;
}

.bloque-no-solvente::after {
    content: "🔒";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 1.5rem;
    opacity: 0.7;
}
</style>

<script>
const ID_ALUMNO = {{ Session::get('usuario')['ID_ALUMNO'] ?? 'null' }};
const apiNotasUrl = 'http://localhost:3000/notas';
const periodosApiUrl = 'http://localhost:3000/periodos/seleccion';

let selectedPeriodoId = null;
let notasData = null;
let periodosData = [];

$(document).ready(function () {
    // Cargar períodos al inicializar
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
            text: periodo.DESCRIPCION_PERIODO
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
    
    $.ajax({
        url: `${apiNotasUrl}/${ID_ALUMNO}/${selectedPeriodoId}`,
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
    // Asegurar que tenemos exactamente 4 bloques
    for (let i = 1; i <= 4; i++) {
        const bloque = bloques.find(b => b.idBloque === (48 + i)) || bloques[i-1];
        const headerElement = $(`#bloque-${i}`);
        
        if (bloque) {
            headerElement.text(bloque.nombreBloque);
            if (bloque.solvente) {
                headerElement.removeClass('no-solvente').addClass('solvente');
            } else {
                headerElement.removeClass('solvente').addClass('no-solvente');
            }
        } else {
            headerElement.text(`Bloque ${i}`);
            headerElement.removeClass('solvente').addClass('no-solvente');
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
        
        // Celdas de notas para cada uno de los 4 bloques
        for (let i = 0; i < 4; i++) {
            const bloque = bloques[i];
            const notaCell = $('<div class="nota-cell"></div>');
            
            if (!bloque || !bloque.solvente) {
                // Bloque no solvente - mostrar bloqueado
                notaCell.addClass('bloque-no-solvente');
            } else {
                // Bloque solvente - mostrar nota si existe
                const nota = encontrarNotaPorMateria(bloque.notas, materia.NUMERO);
                
                if (nota && nota.TOTAL > 0) {
                    notaCell.html(`<div class="nota-value">${nota.TOTAL}</div>`);
                } else {
                    notaCell.html('<div class="nota-empty">Sin nota</div>');
                }
            }
            
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