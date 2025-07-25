@extends("layouts.maestro")
@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<style>
/* Custom styles for Mis Clases */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    position: relative;
    overflow: hidden;
    padding: 30px 0;
    margin-bottom: 20px;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
}

.hero-content {
    position: relative;
    z-index: 2;
    text-align: center;
    color: white;
}

.hero-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 5px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    letter-spacing: -1px;
}

.hero-subtitle {
    font-size: 1rem;
    opacity: 0.9;
    font-weight: 300;
    margin-bottom: 0;
}

.hero-icon {
    font-size: 2.5rem;
    margin-bottom: 10px;
    opacity: 0.9;
}

.period-selector-modern {
    background: white;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 1px solid #e3e6f0;
    margin-bottom: 20px;
}

.period-selector-modern .form-label {
    color: #5a5c69;
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
    gap: 10px;
}

.period-selector-modern .form-select {
    border: 2px solid #e3e6f0;
    border-radius: 10px;
    padding: 8px 12px;
    font-size: 0.95rem;
    font-weight: 500;
    color: #5a5c69;
    background-color: #f8f9fc;
    transition: all 0.3s ease;
}

.period-selector-modern .form-select:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    background-color: white;
}

.period-info {
    background: linear-gradient(45deg, #f8f9fc, #e3e6f0);
    padding: 10px;
    border-radius: 10px;
    margin-top: 10px;
    border-left: 4px solid #667eea;
}

.grade-section {
    background: white;
    border-radius: 15px;
    padding: 15px;
    margin-bottom: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: 1px solid #e3e6f0;
    position: relative;
    overflow: hidden;
}

.grade-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea, #764ba2, #f093fb, #f5576c);
}

.grade-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    padding-bottom: 8px;
    border-bottom: 1px solid #f1f3f4;
}

.grade-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, #667eea, #764ba2);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
    margin-right: 12px;
    box-shadow: 0 4px 8px rgba(102, 126, 234, 0.3);
}

.grade-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #2d3748;
    margin: 0;
    line-height: 1.2;
}

.grade-subtitle {
    color: #718096;
    font-size: 0.8rem;
    margin: 2px 0 0 0;
    font-weight: 500;
}

/* MODIFICADO: Recuadro de materia ahora ES interactuable */
.subject-box {
    background: white;
    border-radius: 12px;
    padding: 12px;
    margin-bottom: 10px;
    border: 1px solid #e3e6f0;
    position: relative;
    overflow: hidden;
    height: 100px;
    min-height: 100px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    text-align: center;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    /* AGREGADO: Efectos interactivos */
    cursor: pointer;
    transition: all 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.subject-box:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    text-decoration: none;
    color: inherit;
}

.subject-box:active {
    transform: translateY(-1px);
}

.subject-box::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: inherit;
    opacity: 0.1;
}

.subject-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.subject-icon {
    font-size: 1.8rem;
    margin-bottom: 8px;
    opacity: 0.9;
    transition: all 0.3s ease;
}

.subject-box:hover .subject-icon {
    transform: scale(1.1);
    opacity: 1;
}

.subject-name {
    font-size: 0.95rem;
    font-weight: 700;
    margin: 0;
    line-height: 1.3;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
}

/* ELIMINADO: Botón de evaluación ya no es necesario */
.materia-container {
    display: flex;
    flex-direction: column;
    height: 100%;
}

.loading-container {
    text-align: center;
    padding: 40px 20px;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #667eea;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 15px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.empty-state {
    text-align: center;
    padding: 40px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.empty-state-icon {
    font-size: 3.5rem;
    color: #cbd5e0;
    margin-bottom: 15px;
}

.error-state {
    text-align: center;
    padding: 40px 20px;
    background: white;
    border-radius: 20px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.08);
}

.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border-radius: 12px;
    padding: 12px;
    text-align: center;
    margin-bottom: 0;
}

.stats-number {
    font-size: 1.8rem;
    font-weight: 700;
    margin-bottom: 0;
}

.stats-label {
    font-size: 0.8rem;
    opacity: 0.9;
}

/* Ajuste para mostrar más materias por fila */
@media (min-width: 992px) {
    .materia-col {
        flex: 0 0 auto;
        width: 25%;
    }
}

@media (min-width: 1200px) {
    .materia-col {
        flex: 0 0 auto;
        width: 20%;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .grade-section {
        padding: 15px;
    }
    
    .grade-header {
        flex-direction: column;
        text-align: center;
    }
    
    .grade-icon {
        margin-right: 0;
        margin-bottom: 10px;
    }
}
</style>

<!-- Hero Section -->
<div class="header-section">
    <div class="header-title">
        <i class="fas fa-credit-card"></i>
        <span>Mis clases</span>
    </div>
</div>

<div class="container-fluid">
    <!-- Period Selector -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="period-selector-modern">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <label for="selectorPeriodo" class="form-label">
                            <i class="bi bi-calendar-event text-primary"></i>
                            Período Escolar
                        </label>
                        <select id="selectorPeriodo" class="form-select">
                            <option value="">Cargando períodos...</option>
                        </select>
                        <div class="period-info" id="infoPeriodo" style="display: none;">
                            <small class="text-muted">
                                <i class="bi bi-info-circle"></i>
                                <span id="periodoDescripcion"></span>
                            </small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stats-card">
                            <div class="stats-number" id="totalClases">0</div>
                            <div class="stats-label">Clases Asignadas</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="loading-container" style="display: none;">
        <div class="loading-spinner"></div>
        <h5 class="text-muted">Cargando clases asignadas...</h5>
    </div>

    <!-- Classes Container -->
    <div id="clasesContainer">
        <!-- Empty State -->
        <div id="noClasesMessage" class="empty-state" style="display: none;">
            <div class="empty-state-icon">
                <i class="bi bi-journal-x"></i>
            </div>
            <h4 class="text-muted mb-3">No tienes clases asignadas</h4>
            <p class="text-muted">No se encontraron clases asignadas para el período seleccionado.</p>
        </div>
        
        <!-- Classes Content -->
        <div id="clasesContent"></div>
    </div>
</div>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};
const apiBaseUrl = 'http://localhost:3000';
let periodoSeleccionado = null;
let clasesData = [];

function obtenerPeriodoSeleccionado() {
    const selectValue = $('#selectorPeriodo').val();
    if (selectValue && selectValue !== '') {
        periodoSeleccionado = parseInt(selectValue);
    }
    console.log('Período obtenido:', periodoSeleccionado);
    return periodoSeleccionado;
}

$(document).ready(function() {
    cargarPeriodos();
});

function cargarPeriodos() {
    $.ajax({
        url: `${apiBaseUrl}/periodos/seleccion`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const selector = $('#selectorPeriodo');
            selector.empty();
            
            if (response && response.length > 0) {
                response.forEach((periodo, index) => {
                    const option = `<option value="${periodo.ID_PERIODO_ESCOLAR}" data-descripcion="${periodo.DESCRIPCION_PERIODO}">${periodo.CODIGO_PERIODO}</option>`;
                    selector.append(option);
                });
                
                const primerPeriodo = response[0].ID_PERIODO_ESCOLAR;
                selector.val(primerPeriodo);
                periodoSeleccionado = parseInt(primerPeriodo);
                
                console.log('Período inicial seleccionado:', periodoSeleccionado);
                actualizarInfoPeriodo();
                cargarClasesAsignadas();
            } else {
                selector.append('<option value="">No hay períodos disponibles</option>');
            }
        },
        error: function(error) {
            console.error('Error al cargar períodos:', error);
            $('#selectorPeriodo').html('<option value="">Error al cargar períodos</option>');
        }
    });
}

$('#selectorPeriodo').on('change', function() {
    const nuevoValor = $(this).val();
    console.log('Cambio detectado en selector:', nuevoValor);
    
    if (nuevoValor && nuevoValor !== '') {
        periodoSeleccionado = parseInt(nuevoValor);
        console.log('Nuevo período seleccionado:', periodoSeleccionado);
        actualizarInfoPeriodo();
        cargarClasesAsignadas();
    } else {
        periodoSeleccionado = null;
    }
});

function actualizarInfoPeriodo() {
    const selector = $('#selectorPeriodo');
    const descripcion = selector.find('option:selected').data('descripcion');
    
    if (descripcion) {
        $('#periodoDescripcion').text(descripcion);
        $('#infoPeriodo').show();
    } else {
        $('#infoPeriodo').hide();
    }
}

function cargarClasesAsignadas() {
    obtenerPeriodoSeleccionado();
    
    if (!periodoSeleccionado || ID_PERSONA === 'null') {
        console.log('No se puede cargar clases - Período:', periodoSeleccionado, 'ID_PERSONA:', ID_PERSONA);
        return;
    }
    
    mostrarCargando(true);
    
    const datos = {
        ID_PERSONA: ID_PERSONA,
        ID_PERIODO_ESCOLAR: periodoSeleccionado
    };
    
    console.log('Cargando clases con datos:', datos);
    
    $.ajax({
        url: `${apiBaseUrl}/materias-grado/maestros`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            clasesData = response;
            mostrarCargando(false);
            mostrarClases(response);
            actualizarEstadisticas(response);
        },
        error: function(error) {
            console.error('Error al cargar clases:', error);
            mostrarCargando(false);
            mostrarError();
        }
    });
}

function mostrarCargando(mostrar) {
    if (mostrar) {
        $('#loadingIndicator').show();
        $('#clasesContent').empty();
        $('#noClasesMessage').hide();
    } else {
        $('#loadingIndicator').hide();
    }
}

function actualizarEstadisticas(clases) {
    let totalClases = 0;
    if (clases && clases.length > 0) {
        clases.forEach(grado => {
            totalClases += grado.materias.length;
        });
    }
    $('#totalClases').text(totalClases);
}

function mostrarClases(clases) {
    const container = $('#clasesContent');
    container.empty();
    
    if (!clases || clases.length === 0) {
        $('#noClasesMessage').show();
        return;
    }
    
    $('#noClasesMessage').hide();
    
    clases.forEach((grado, index) => {
        const gradoHtml = `
            <div class="grade-section" style="animation-delay: ${index * 0.1}s;">
                <div class="grade-header">
                    <div class="grade-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>
                    <div>
                        <h3 class="grade-title">${grado.nombreGrado}</h3>
                        <p class="grade-subtitle">${grado.materias.length} materia${grado.materias.length !== 1 ? 's' : ''} asignada${grado.materias.length !== 1 ? 's' : ''}</p>
                    </div>
                </div>
                <div class="row g-2" id="materias-${index}">
                </div>
            </div>
        `;
        container.append(gradoHtml);
        
        const materiasContainer = $(`#materias-${index}`);
        
        grado.materias.forEach((materia, materiaIndex) => {
            const colorFondo = materia.color || '#6c757d';
            const colorTexto = materia.usaLetrasBlancas === 'Y' ? 'white' : 'black';
            const periodoActual = obtenerPeriodoSeleccionado();
            
            const materiaHtml = `
                <div class="col-6 col-sm-4 col-md-3 col-lg-2 materia-col">
                    <div class="materia-container">
                        <!-- MODIFICADO: Ahora todo el recuadro es clickeable -->
                        <a href="/maestro/evaluaciones/${periodoActual}/${grado.idGrado}/${materia.idMateria}"
                           class="subject-box"
                           style="background-color: ${colorFondo}; color: ${colorTexto}; animation-delay: ${(index * 0.1) + (materiaIndex * 0.05)}s;">
                            <div class="subject-content">
                                <div class="subject-icon">
                                    <i class="bi bi-book-fill"></i>
                                </div>
                                <h5 class="subject-name">${materia.nombreMateria}</h5>
                            </div>
                        </a>
                    </div>
                </div>
            `;
            materiasContainer.append(materiaHtml);
        });
    });
}

function mostrarError() {
    const container = $('#clasesContent');
    container.html(`
        <div class="error-state">
            <div class="empty-state-icon text-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h4 class="text-danger mb-3">Error al cargar las clases</h4>
            <p class="text-muted mb-4">Ocurrió un error al cargar tus clases asignadas. Por favor, intenta nuevamente.</p>
            <button class="btn btn-primary" onclick="cargarClasesAsignadas()">
                <i class="bi bi-arrow-clockwise me-2"></i>Reintentar
            </button>
        </div>
    `);
}
</script>
@endsection
