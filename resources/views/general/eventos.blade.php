@php
    $rolUsuario = Session::get('usuario')['ROL_PERSONA'] ?? null;
    $layout = match($rolUsuario) {
        'M' => 'layouts.maestro', 
        'A' => 'layouts.alumnos'
    };
@endphp
@extends($layout)
@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<style>
.calendar-container {
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

.calendar-header {
    position: relative;
    width: 100%;
    height: 120px;
    overflow: hidden;
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
    border-radius: 12px 12px 0 0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    color: white;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.calendar-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-image:
        radial-gradient(circle at 20% 50%, rgba(148, 163, 184, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(148, 163, 184, 0.08) 0%, transparent 50%);
    opacity: 0.6;
}

.calendar-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 3px;
    background: linear-gradient(90deg, #64748b 0%, #475569 50%, #334155 100%);
}

.calendar-nav {
    display: flex;
    align-items: center;
    gap: 15px;
    position: relative;
    z-index: 1;
}

.nav-btn {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    font-weight: 600;
    position: relative;
    z-index: 1;
}

.nav-btn:hover {
    background: rgba(255, 255, 255, 0.3);
    transform: translateY(-1px);
}

.calendar-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background-color: #334155;
}

.calendar-day-header {
    background: #334155;
    color: white;
    padding: 15px 12px;
    text-align: center;
    font-weight: 700;
    font-size: 14px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.calendar-day {
    background: white;
    min-height: 120px;
    padding: 8px;
    cursor: pointer;
    transition: all 0.2s ease;
    position: relative;
    border: 2px solid transparent;
}

.calendar-day:hover {
    background: #f8fafc;
    border-color: #64748b;
}

.calendar-day.other-month {
    background: #f9fafb;
    color: #9ca3af;
}

.calendar-day.today {
    border-color: #64748b;
    background: rgba(255, 255, 255, 0.77);
}

.day-number {
    font-weight: 700;
    font-size: 16px;
    margin-bottom: 4px;
    color: #1f2937;
}

.calendar-day.other-month .day-number {
    color: #9ca3af;
}

.event-item {
    color: white;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 11px;
    margin-bottom: 3px;
    cursor: pointer;
    transition: all 0.2s ease;
    display: block;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
    font-weight: 600;
    text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    border: 1px solid rgba(255,255,255,0.2);
}

.event-item:hover {
    transform: scale(1.05);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.event-item.maestros {
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    border-color: #1e40af;
}

.event-item.alumnos {
    background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
    border-color: #991b1b;
}

.event-item.todos {
    background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
    border-color: #166534;
}

.event-item.suspende-clases {
    border-left: 4px solid #f59e0b;
    box-shadow: 0 0 0 1px #f59e0b;
}

.events-count {
    position: absolute;
    top: 4px;
    right: 4px;
    background: #64748b;
    color: white;
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    font-weight: bold;
    box-shadow: 0 2px 4px rgba(0,0,0,0.2);
}

.add-event-btn {
    background: #64748b;
    color: white;
    border: none;
    padding: 12px 24px;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s ease;
}

.add-event-btn:hover {
    background: #475569;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(100, 116, 139, 0.3);
}

/* Mejorar visibilidad del mes actual */
#current-month-year {
    font-size: 1.8rem;
    font-weight: 800;
    color: white;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    margin: 0;
    position: relative;
    z-index: 1;
}

.empty-day-area {
    min-height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    font-style: italic;
    font-size: 12px;
}

/* Controles superiores simplificados */
.controls-section {
    background: white;
    padding: 20px;
    border-bottom: 1px solid #e5e7eb;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}
</style>

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-calendar-alt"></i>
        <span>Calendario de Eventos</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>

<div class="container-fluid mt-4">
    <!-- Calendario -->
    <div class="card shadow">
        <div class="calendar-container">
            <div class="calendar-header">
                <div class="calendar-nav">
                    <button class="nav-btn" onclick="changeMonth(-1)">
                        <i class="fas fa-chevron-left"></i> Anterior
                    </button>
                    <h3 id="current-month-year"></h3>
                    <button class="nav-btn" onclick="changeMonth(1)">
                        Siguiente <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button class="nav-btn" onclick="goToToday()">
                        <i class="fas fa-calendar-day"></i> Hoy
                    </button>
                </div>
            </div>
            
            <div class="calendar-grid" id="calendar-grid">
                <!-- Headers de días -->
                <div class="calendar-day-header">Dom</div>
                <div class="calendar-day-header">Lun</div>
                <div class="calendar-day-header">Mar</div>
                <div class="calendar-day-header">Mié</div>
                <div class="calendar-day-header">Jue</div>
                <div class="calendar-day-header">Vie</div>
                <div class="calendar-day-header">Sáb</div>
                
                <!-- Días del calendario se generarán dinámicamente -->
            </div>
        </div>
    </div>
</div>


<script>
// Variables globales
const ROL_PERSONA = @json(substr(Session::get('usuario')['ROL_PERSONA'] ?? '', 0, 1));
const PERIODO_ESCOLAR = {{ Session::get('usuario')['PERIODO_ESCOLAR'] ?? 'null' }};
let currentDate = new Date();
let eventos = [];
let selectedEventId = null;

// Nombres de meses
const monthNames = [
    'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
    'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
];

$(document).ready(function() {
    renderCalendar();
    cargarEventos();
});

// Funciones de manejo de errores
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

// Cambiar mes
function changeMonth(direction) {
    currentDate.setMonth(currentDate.getMonth() + direction);
    renderCalendar();
    cargarEventos(); // Recargar eventos al cambiar de mes
}

// Ir a hoy
function goToToday() {
    currentDate = new Date();
    renderCalendar();
    cargarEventos(); // Recargar eventos al ir a hoy
}

// Renderizar calendario
function renderCalendar() {
    const year = currentDate.getFullYear();
    const month = currentDate.getMonth();
    
    // Actualizar título del mes y año
    $('#current-month-year').text(`${monthNames[month]} ${year}`);
    
    // Limpiar grid (mantener headers)
    const grid = $('#calendar-grid');
    grid.find('.calendar-day').remove();
    
    // Primer día del mes y último día
    const firstDay = new Date(year, month, 1);
    const lastDay = new Date(year, month + 1, 0);
    const startDate = new Date(firstDay);
    startDate.setDate(startDate.getDate() - firstDay.getDay());
    
    // Generar días
    const today = new Date();
    for (let i = 0; i < 42; i++) {
        const date = new Date(startDate);
        date.setDate(startDate.getDate() + i);
        
        const dayElement = createDayElement(date, month, today);
        grid.append(dayElement);
    }
}

// Crear elemento de día
function createDayElement(date, currentMonth, today) {
    const dayDiv = $('<div>').addClass('calendar-day');
    const isOtherMonth = date.getMonth() !== currentMonth;
    const isToday = date.toDateString() === today.toDateString();
    
    if (isOtherMonth) dayDiv.addClass('other-month');
    if (isToday) dayDiv.addClass('today');
    
    // Número del día
    const dayNumber = $('<div>').addClass('day-number').text(date.getDate());
    dayDiv.append(dayNumber);
    
    // Eventos del día
    const dayEvents = getEventsForDate(date);
    let visibleEvents = 0;
    const maxVisible = 3;
    
    dayEvents.forEach((evento, index) => {
        if (visibleEvents < maxVisible) {
            const eventElement = createEventElement(evento);
            dayDiv.append(eventElement);
            visibleEvents++;
        }
    });
    
    // Contador de eventos adicionales
    if (dayEvents.length > maxVisible) {
        const moreCount = $('<div>').addClass('events-count').text(`+${dayEvents.length - maxVisible}`);
        dayDiv.append(moreCount);
    }
    
    // Si no hay eventos, mostrar área vacía
    if (dayEvents.length === 0) {
        const emptyArea = $('<div>').addClass('empty-day-area').text('');
        dayDiv.append(emptyArea);
    }
    
    // Event listener para el día (crear evento)
    dayDiv.click(function(e) {
        // Solo abrir modal de creación si no se hizo click en un evento
        if (!$(e.target).hasClass('event-item')) {
            openEventModal(date);
        }
    });
    
    return dayDiv;
}

function createEventElement(evento) {
    const eventDiv = $('<div>').addClass('event-item');

    if (evento.APLICA_PARA === 'M') eventDiv.addClass('maestros');
    else if (evento.APLICA_PARA === 'A') eventDiv.addClass('alumnos');
    else eventDiv.addClass('todos');
    
    if (evento.SE_SUSPENDEN_CLASES === 'Y') eventDiv.addClass('suspende-clases');
    
    eventDiv.text(evento.NOMBRE_EVENTO + ' - ' + evento.HORA_EVENTO);

    eventDiv.click(function(e) {
        e.stopPropagation();
        editEvent(evento);
    });
    
    return eventDiv;
}

// Obtener eventos para una fecha
function getEventsForDate(date) {
    const dateStr = date.toISOString().split('T')[0];
    return eventos.filter(evento => {
        const eventDate = new Date(evento.FECHA_EVENTO).toISOString().split('T')[0];
        return eventDate === dateStr;
    });
}

// Cargar eventos
function cargarEventos() {
    $.ajax({
        url: 'http://localhost:3000/eventos/lista',
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify({
            APLICA_PARA: ROL_PERSONA
        }),
        success: function(response) {
            eventos = response;
            renderCalendar(); // Re-renderizar después de cargar eventos
        },
        error: function(xhr) {
            console.error('Error al cargar eventos:', xhr);
            showError('Error al cargar los eventos');
        }
    });
}
</script>
@endsection