@extends("layouts.header")

@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Estilos personalizados para administración de precios */
.hero-section {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    background-color: white;
}

.period-info {
    background: linear-gradient(45deg, #f8f9fc, #e3e6f0);
    padding: 10px;
    border-radius: 10px;
    margin-top: 10px;
    border-left: 4px solid #28a745;
}

.precios-table {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: 1px solid #e3e6f0;
}

.precio-input {
    width: 120px;
    text-align: right;
    border: 2px solid #e3e6f0;
    border-radius: 8px;
    padding: 8px 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.precio-input:focus {
    border-color: #28a745;
    box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    background-color: #f8fff9;
}

.precio-input.changed {
    border-color: #ffc107;
    background-color: #fffbf0;
}

.grado-row:hover {
    background-color: #f8f9fa;
}

.stats-card {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
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

.loading-container {
    text-align: center;
    padding: 40px 20px;
}

.loading-spinner {
    width: 50px;
    height: 50px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #28a745;
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

.nivel-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-align: center;
    min-width: 30px;
}

.nivel-1 { background-color: #e3f2fd; color: #1976d2; }
.nivel-2 { background-color: #f3e5f5; color: #7b1fa2; }
.nivel-3 { background-color: #e8f5e8; color: #388e3c; }
.nivel-4 { background-color: #fff3e0; color: #f57c00; }
.nivel-5 { background-color: #fce4ec; color: #c2185b; }
.nivel-6 { background-color: #f1f8e9; color: #689f38; }

.btn-guardar-precios {
    background: linear-gradient(135deg, #28a745, #20c997);
    border: none;
    border-radius: 12px;
    padding: 12px 30px;
    font-size: 1.1rem;
    font-weight: 600;
    color: white;
    box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
    transition: all 0.3s ease;
}

.btn-guardar-precios:hover {
    background: linear-gradient(135deg, #218838, #1e7e34);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(40, 167, 69, 0.4);
    color: white;
}

.currency-symbol {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    font-weight: 600;
}

.precio-input-container {
    position: relative;
}

.precio-input-container .precio-input {
    padding-left: 25px;
}
</style>

<!-- Hero Section -->
<div class="header-section">
    <div class="header-title">
        <i class="fa-solid fa-dollar-sign"></i>
        <span>Precios por grado</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>

<div class="container-fluid">
    <!-- Period Selector -->
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="period-selector-modern">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <label for="selectorPeriodo" class="form-label">
                            <i class="bi bi-calendar-event text-success"></i>
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
                            <div class="stats-number" id="totalGrados">0</div>
                            <div class="stats-label">Grados Configurados</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Indicator -->
    <div id="loadingIndicator" class="loading-container" style="display: none;">
        <div class="loading-spinner"></div>
        <h5 class="text-muted">Cargando precios...</h5>
    </div>

    <!-- Precios Container -->
    <div id="preciosContainer">
        <!-- Empty State -->
        <div id="noPreciosMessage" class="empty-state" style="display: none;">
            <div class="empty-state-icon">
                <i class="bi bi-currency-dollar"></i>
            </div>
            <h4 class="text-muted mb-3">No hay precios configurados</h4>
            <p class="text-muted">Selecciona un período escolar para configurar los precios.</p>
        </div>
        
        <!-- Precios Content -->
        <div id="preciosContent"></div>
    </div>
</div>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};
const apiBaseUrl = 'http://localhost:3000';
let periodoSeleccionado = null;
let preciosData = [];
let preciosOriginales = [];

// Función para obtener el período seleccionado actual
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
                
                // Seleccionar el primer período por defecto
                const primerPeriodo = response[0].ID_PERIODO_ESCOLAR;
                selector.val(primerPeriodo);
                
                // Actualizar la variable global después de establecer el valor
                periodoSeleccionado = parseInt(primerPeriodo);
                
                console.log('Período inicial seleccionado:', periodoSeleccionado);
                actualizarInfoPeriodo();
                cargarPrecios();
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

// Evento change del selector
$('#selectorPeriodo').on('change', function() {
    const nuevoValor = $(this).val();
    console.log('Cambio detectado en selector:', nuevoValor);
    
    if (nuevoValor && nuevoValor !== '') {
        periodoSeleccionado = parseInt(nuevoValor);
        console.log('Nuevo período seleccionado:', periodoSeleccionado);
        actualizarInfoPeriodo();
        cargarPrecios();
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

function cargarPrecios() {
    obtenerPeriodoSeleccionado();
    
    if (!periodoSeleccionado) {
        console.log('No se puede cargar precios - Período no seleccionado');
        return;
    }

    mostrarCargando(true);
    
    const datos = {
        ID_PERIODO_ESCOLAR: periodoSeleccionado
    };

    console.log('Cargando precios con datos:', datos);

    $.ajax({
        url: `${apiBaseUrl}/precios/lista`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            preciosData = response.data || [];
            preciosOriginales = JSON.parse(JSON.stringify(preciosData)); // Copia profunda
            mostrarCargando(false);
            mostrarPrecios(preciosData);
            actualizarEstadisticas(preciosData);
        },
        error: function(error) {
            console.error('Error al cargar precios:', error);
            mostrarCargando(false);
            mostrarError();
        }
    });
}

function mostrarCargando(mostrar) {
    if (mostrar) {
        $('#loadingIndicator').show();
        $('#preciosContent').empty();
        $('#noPreciosMessage').hide();
    } else {
        $('#loadingIndicator').hide();
    }
}

function actualizarEstadisticas(precios) {
    const totalGrados = precios ? precios.length : 0;
    $('#totalGrados').text(totalGrados);
}

function mostrarPrecios(precios) {
    const container = $('#preciosContent');
    container.empty();
    
    if (!precios || precios.length === 0) {
        $('#noPreciosMessage').show();
        return;
    }
    
    $('#noPreciosMessage').hide();
    
    const tablaHtml = `
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="precios-table">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="mb-0">
                            <i class="bi bi-currency-dollar text-success me-2"></i>
                            Configuración de Precios por Grado
                        </h4>
                        <button type="button" class="btn btn-guardar-precios" id="btnGuardarPrecios">
                            <i class="bi bi-check-circle me-2"></i>Guardar Cambios
                        </button>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-success">
                                <tr>
                                    <th scope="col" width="5%">Nivel</th>
                                    <th scope="col" width="25%">Grado</th>
                                    <th scope="col" width="15%">Sección</th>
                                    <th scope="col" width="18%">Mensualidad</th>
                                    <th scope="col" width="18%">Inscripción</th>
                                    <th scope="col" width="19%">Mora/Insolvencia</th>
                                </tr>
                            </thead>
                            <tbody id="tablaPrecios">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    container.html(tablaHtml);
    
    const tbody = $('#tablaPrecios');
    
    precios.forEach((grado, index) => {
        const nivelClass = `nivel-${Math.min(grado.NIVEL_GRADO, 6)}`;
        
        const fila = `
            <tr class="grado-row" data-grado-id="${grado.ID_GRADO}">
                <td>
                    <span class="nivel-badge ${nivelClass}">${grado.NIVEL_GRADO}</span>
                </td>
                <td>
                    <div class="fw-semibold">${grado.NOMBRE_GRADO}</div>
                    <small class="text-muted">${grado.CODIGO_GRADO}</small>
                </td>
                <td class="text-center">
                    <span class="badge bg-secondary">${grado.SECCION_GRADO}</span>
                </td>
                <td>
                    <div class="precio-input-container">
                        <span class="currency-symbol">Q</span>
                        <input 
                            type="number" 
                            class="form-control precio-input" 
                            value="${grado.PRECIO_DE_MENSUALIDAD}" 
                            min="0" 
                            step="0.01"
                            data-grado-id="${grado.ID_GRADO}"
                            data-tipo="mensualidad"
                            onchange="marcarCambio(this)"
                        >
                    </div>
                </td>
                <td>
                    <div class="precio-input-container">
                        <span class="currency-symbol">Q</span>
                        <input 
                            type="number" 
                            class="form-control precio-input" 
                            value="${grado.PRECIO_DE_INSCRIPCION}" 
                            min="0" 
                            step="0.01"
                            data-grado-id="${grado.ID_GRADO}"
                            data-tipo="inscripcion"
                            onchange="marcarCambio(this)"
                        >
                    </div>
                </td>
                <td>
                    <div class="precio-input-container">
                        <span class="currency-symbol">Q</span>
                        <input 
                            type="number" 
                            class="form-control precio-input" 
                            value="${grado.MORA_AUMENTO_INSOLVENCIA}" 
                            min="0" 
                            step="0.01"
                            data-grado-id="${grado.ID_GRADO}"
                            data-tipo="mora"
                            onchange="marcarCambio(this)"
                        >
                    </div>
                </td>
            </tr>
        `;
        tbody.append(fila);
    });
    
    // Agregar evento al botón guardar
    $('#btnGuardarPrecios').click(function() {
        confirmarGuardado();
    });
}

function marcarCambio(input) {
    const $input = $(input);
    const gradoId = $input.data('grado-id');
    const tipo = $input.data('tipo');
    const valorActual = parseFloat($input.val()) || 0;
    
    // Buscar el valor original
    const gradoOriginal = preciosOriginales.find(g => g.ID_GRADO === gradoId);
    let valorOriginal = 0;
    
    if (gradoOriginal) {
        switch(tipo) {
            case 'mensualidad':
                valorOriginal = gradoOriginal.PRECIO_DE_MENSUALIDAD;
                break;
            case 'inscripcion':
                valorOriginal = gradoOriginal.PRECIO_DE_INSCRIPCION;
                break;
            case 'mora':
                valorOriginal = gradoOriginal.MORA_AUMENTO_INSOLVENCIA;
                break;
        }
    }
    
    // Marcar como cambiado si es diferente al original
    if (valorActual !== valorOriginal) {
        $input.addClass('changed');
    } else {
        $input.removeClass('changed');
    }
    
    console.log(`Cambio detectado - Grado: ${gradoId}, Tipo: ${tipo}, Valor: ${valorActual}`);
}

function confirmarGuardado() {
    // Verificar si hay cambios
    const inputsCambiados = $('.precio-input.changed').length;
    
    if (inputsCambiados === 0) {
        Swal.fire({
            icon: 'info',
            title: 'Sin cambios',
            text: 'No se han detectado cambios en los precios.',
            timer: 2000,
            showConfirmButton: false
        });
        return;
    }
    
    Swal.fire({
        title: '¿Confirmar guardado?',
        text: `Se guardarán los cambios en ${inputsCambiados} precio${inputsCambiados !== 1 ? 's' : ''}`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, guardar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            guardarPrecios();
        }
    });
}

function guardarPrecios() {
    // Preparar datos para envío - CORREGIDO: leer directamente de los inputs
    const preciosParaGuardar = [];
    
    // Recorrer cada fila de la tabla para obtener los valores actuales
    $('#tablaPrecios tr').each(function() {
        const $fila = $(this);
        const gradoId = $fila.data('grado-id');
        
        if (gradoId) {
            const mensualidad = parseFloat($fila.find('input[data-tipo="mensualidad"]').val()) || 0;
            const inscripcion = parseFloat($fila.find('input[data-tipo="inscripcion"]').val()) || 0;
            const mora = parseFloat($fila.find('input[data-tipo="mora"]').val()) || 0;
            
            preciosParaGuardar.push({
                ID_GRADO: gradoId,
                PRECIO_MENSUALIDAD: mensualidad,
                PRECIO_INSCRIPCION: inscripcion,
                MORA_AUMENTO_INSOLVENCIA: mora
            });
        }
    });
    
    const datos = {
        ID_PERIODO_ESCOLAR: periodoSeleccionado,
        precios: preciosParaGuardar
    };
    
    console.log('Guardando precios:', datos);
    
    // Mostrar loading
    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere mientras se guardan los precios',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: `${apiBaseUrl}/precios`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            Swal.close();
            
            if (response.mensaje === "" || !response.mensaje) {
                // Éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Los precios se han guardado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Recargar datos para mostrar cambios y limpiar marcas de cambio
                    cargarPrecios();
                });
            } else {
                // Error del servidor
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar',
                    text: response.mensaje,
                    confirmButtonText: 'Entendido'
                });
            }
        },
        error: function(error) {
            Swal.close();
            console.error('Error al guardar precios:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Por favor intente nuevamente.',
                confirmButtonText: 'Entendido'
            });
        }
    });
}

function mostrarError() {
    const container = $('#preciosContent');
    container.html(`
        <div class="empty-state">
            <div class="empty-state-icon text-danger">
                <i class="bi bi-exclamation-triangle-fill"></i>
            </div>
            <h4 class="text-danger mb-3">Error al cargar los precios</h4>
            <p class="text-muted mb-4">Ocurrió un error al cargar los precios. Por favor, intenta nuevamente.</p>
            <button class="btn btn-success" onclick="cargarPrecios()">
                <i class="bi bi-arrow-clockwise me-2"></i>Reintentar
            </button>
        </div>
    `);
}
</script>
@endsection