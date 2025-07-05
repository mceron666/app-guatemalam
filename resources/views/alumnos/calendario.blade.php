@extends("layouts.header")

@section("contenido")

<link href="/css/modal.css" rel="stylesheet">

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-calendar-week"></i>
        <span>Mi Calendario Semanal</span>  
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
    background-color: #ef4444;
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
    transition: background-color 0.2s;
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

.entry-subject {
    font-size: 0.85rem;
    font-weight: bold;
    text-align: center;
}

.empty-cell {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #6c757d;
    font-size: 0.9rem;
    font-style: italic;
    background-color: #f8f9fa;
}

.cell-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 100%;
    color: #6c757d;
    font-size: 0.8rem;
}

/* Estilos adicionales para vista de solo lectura */
.calendar-entry {
    cursor: default;
}

.calendar-entry:hover {
    opacity: 0.9;
}

.no-data-message {
    grid-column: 1 / -1;
    text-align: center;
    padding: 40px;
    color: #6c757d;
    font-style: italic;
    background-color: #f8f9fa;
    border-radius: 8px;
    margin: 20px;
}
</style>

<script>
// Obtener datos del usuario desde la sesión
const usuarioData = @json(Session::get('usuario', []));
const ID_PERSONA = usuarioData.ID_PERSONA || null;
const PERIODO_ESCOLAR = usuarioData.PERIODO_ESCOLAR || null;
const GRADO_ACTUAL = usuarioData.GRADO_ACTUAL || null;

const apiBaseUrl = 'http://localhost:3000/calendario';

// Días de la semana
const daysOfWeek = [
    { id: 1, name: 'Lunes' },
    { id: 2, name: 'Martes' },
    { id: 3, name: 'Miércoles' },
    { id: 4, name: 'Jueves' },
    { id: 5, name: 'Viernes' }
];

// Variables globales
let horariosData = [];
let periodoInfo = null;
let gradoInfo = null;

// Cargar información del período y grado
function cargarInfoPeriodoGrado() {
    if (!PERIODO_ESCOLAR || !GRADO_ACTUAL) {
        console.error('Datos de usuario no válidos');
        showNoDataMessage('No se pudieron obtener los datos del usuario');
        return;
    }
    
    // Cargar información del período
    axios.get('http://localhost:3000/periodos/seleccion')
        .then(response => {
            const periodos = response.data;
            const periodo = periodos.find(p => p.ID_PERIODO_ESCOLAR == PERIODO_ESCOLAR);
            if (periodo) {
                periodoInfo = periodo;
                document.getElementById('header-periodo-codigo').textContent = periodo.CODIGO_PERIODO;
            } else {
                document.getElementById('header-periodo-codigo').textContent = 'No encontrado';
            }
        })
        .catch(error => {
            console.error('Error al cargar información del período:', error);
            document.getElementById('header-periodo-codigo').textContent = 'Error al cargar';
        });
    
    // Cargar información del grado
    $.ajax({
        url: `http://localhost:3000/grados/${GRADO_ACTUAL}/i`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const grado = response.data[0];
            if (grado) {
                gradoInfo = grado;
                document.getElementById('header-grado-nombre').textContent = grado.NOMBRE_GRADO;
            } else {
                document.getElementById('header-grado-nombre').textContent = 'No encontrado';
            }
        },
        error: function(error) {
            console.error('Error al cargar información del grado:', error);
            document.getElementById('header-grado-nombre').textContent = 'Error al cargar';
        }
    });
}

// Cargar horarios disponibles
function cargarHorarios() {
    if (!PERIODO_ESCOLAR || !GRADO_ACTUAL) {
        console.error('Datos de usuario no válidos');
        showNoDataMessage('No se pudieron obtener los datos del usuario');
        return;
    }
    
    const filtros = {
        ID_PERIODO_ESCOLAR: PERIODO_ESCOLAR,
        ID_GRADO: GRADO_ACTUAL
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
                console.log('No se recibieron horarios del servidor');
                showNoDataMessage('No hay horarios disponibles para mostrar');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar horarios:', { xhr, status, error });
            showNoDataMessage('Error al cargar los horarios del calendario');
        }
    });
}

// Mostrar mensaje cuando no hay datos
function showNoDataMessage(message) {
    const calendarBody = document.getElementById('calendar-body');
    calendarBody.innerHTML = `<div class="no-data-message">${message}</div>`;
}

// Renderizar el calendario
function renderCalendar() {
    if (horariosData.length === 0) {
        console.log('No hay horarios para renderizar');
        showNoDataMessage('No hay horarios para mostrar');
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
            loadCellData(cell, day.id, horario.CODIGO_HORARIO);
            
            calendarBody.appendChild(cell);
        });
    });
    
    console.log('Calendario renderizado completamente');
}

// Cargar datos de una celda específica
function loadCellData(cell, day, codigoHorario) {
    const filtros = {
        ID_PERIODO_ESCOLAR: PERIODO_ESCOLAR,
        ID_GRADO: GRADO_ACTUAL
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
                cell.innerHTML = renderCalendarEntry(entry);
            } else {
                // Celda vacía
                cell.innerHTML = '<div class="empty-cell">Libre</div>';
            }
        },
        error: function(xhr, status, error) {
            console.error(`Error al cargar celda ${day}-${codigoHorario}:`, error);
            // En caso de error, mostrar como celda vacía
            cell.innerHTML = '<div class="empty-cell">Error al cargar</div>';
        }
    });
}

// Renderizar entrada del calendario (solo vista)
function renderCalendarEntry(entry) {
    let html = '';
    
    if (entry.ES_RECREO === 'Y') {
        html = `
            <div class="calendar-entry recreo">
                <div class="entry-subject">
                    <i class="fas fa-coffee"></i> Recreo
                </div>
            </div>
        `;
    } else {
        const backgroundColor = entry.COLOR_MATERIA || '#ef4444';
        // Determinar color del texto basado en USA_LETRAS_BLANCAS
        const textColor = entry.USA_LETRAS_BLANCAS === 'Y' ? 'white' : 'black';
        
        html = `
            <div class="calendar-entry materia" style="background-color: ${backgroundColor}; border-left-color: ${backgroundColor}; color: ${textColor};">
                <div class="entry-subject">
                    <i class="fas fa-book"></i> ${entry.NOMBRE_MATERIA || 'Materia'}
                </div>
            </div>
        `;
    }
    
    return html;
}

// Inicialización
$(document).ready(function() {
    // Verificar datos del usuario
    if (!ID_PERSONA || !PERIODO_ESCOLAR || !GRADO_ACTUAL) {
        console.error('Datos de usuario incompletos:', { ID_PERSONA, PERIODO_ESCOLAR, GRADO_ACTUAL });
        showNoDataMessage('No se pudieron obtener los datos del usuario. Por favor, inicie sesión nuevamente.');
        return;
    }
    
    console.log('Datos del usuario:', { ID_PERSONA, PERIODO_ESCOLAR, GRADO_ACTUAL });
    
    // Cargar datos iniciales
    cargarInfoPeriodoGrado();
    cargarHorarios(); // Esto iniciará el renderizado del calendario
});
</script>

@endsection