@extends("layouts.header")

@section("contenido")
<link href="/css/form.css" rel="stylesheet">
<div class="container mt-3">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-2">
            <h5 class="mb-0" id="titulo"><i class="bi bi-calendar-range me-2"></i>Gestión de Período Académico</h5>
        </div>
        <div class="card-body p-3 bg-light">
            <!-- Área para mensajes de alerta -->
            <div id="errorMessageContainer" class="alert alert-danger d-none py-2">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="errorMessage">Mensaje de error aquí</span>
                </div>
            </div>

            <form id="periodoForm" class="needs-validation">
                <!-- Información General del Período -->
                <div class="card mb-3 border-0 shadow-sm">
                    <div class="card-header bg-white py-2">
                        <h6 class="mb-0 text-success"><i class="bi bi-calendar-check me-2"></i>Información General</h6>
                    </div>
                    <div class="card-body py-2 px-3">
                        <div class="row g-2 mb-2">
                            <div class="col-md-3">
                                <label for="codigo_periodo" class="form-label small fw-semibold">
                                    <i class="bi bi-hash me-1 text-success"></i>Código <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="codigo_periodo" name="CODIGO_PERIODO" maxlength="15" required
                                    value="{{ old('CODIGO_PERIODO') }}">
                            </div>
                            <div class="col-md-9">
                                <label for="descripcion_periodo" class="form-label small fw-semibold">
                                    <i class="bi bi-card-text me-1 text-success"></i>Descripción <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control form-control-sm" 
                                    id="descripcion_periodo" name="DESCRIPCION_PERIODO" maxlength="50" required
                                    value="{{ old('DESCRIPCION_PERIODO') }}">
                            </div>   
                        </div>                                                 
                        
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="fecha_inicio_periodo" class="form-label small fw-semibold">
                                    <i class="bi bi-calendar-plus me-1 text-success"></i>Fecha de Inicio <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control form-control-sm" 
                                    id="fecha_inicio_periodo" name="FECHA_INICIO_PERIODO" required
                                    value="{{ old('FECHA_INICIO_PERIODO') }}">
                            </div>                            
                            <div class="col-md-6">
                                <label for="fecha_finaliza_periodo" class="form-label small fw-semibold">
                                    <i class="bi bi-calendar-minus me-1 text-success"></i>Fecha de Finalización <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control form-control-sm" 
                                    id="fecha_finaliza_periodo" name="FECHA_FINALIZA_PERIODO" required
                                    value="{{ old('FECHA_FINALIZA_PERIODO') }}">
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Bloques -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-2">
                        <h6 class="mb-0 text-success"><i class="bi bi-grid-3x3-gap me-2"></i>Bloques Académicos</h6>
                    </div>
                    <div class="card-body py-2 px-3">
                        <!-- Bloque 1 y 2 -->
                        <div class="row g-2 mb-2">
                            <div class="col-md-3">
                                <div class="bg-light rounded p-1 mb-1 text-center">
                                    <span class="badge bg-success">Bloque 1</span>
                                </div>
                                <div class="row g-1">
                                    <div class="col-6">
                                        <label for="fecha_inicio_bloque_1" class="form-label small fw-semibold">Inicio</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_inicio_bloque_1" name="FECHA_INICIO_BLOQUE_1" required
                                            value="{{ old('FECHA_INICIO_BLOQUE_1') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="fecha_finaliza_bloque_1" class="form-label small fw-semibold">Fin</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_finaliza_bloque_1" name="FECHA_FINALIZA_BLOQUE_1" required
                                            value="{{ old('FECHA_FINALIZA_BLOQUE_1') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-light rounded p-1 mb-1 text-center">
                                    <span class="badge bg-success">Bloque 2</span>
                                </div>
                                <div class="row g-1">
                                    <div class="col-6">
                                        <label for="fecha_inicio_bloque_2" class="form-label small fw-semibold">Inicio</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_inicio_bloque_2" name="FECHA_INICIO_BLOQUE_2" required
                                            value="{{ old('FECHA_INICIO_BLOQUE_2') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="fecha_finaliza_bloque_2" class="form-label small fw-semibold">Fin</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_finaliza_bloque_2" name="FECHA_FINALIZA_BLOQUE_2" required
                                            value="{{ old('FECHA_FINALIZA_BLOQUE_2') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-light rounded p-1 mb-1 text-center">
                                    <span class="badge bg-success">Bloque 3</span>
                                </div>
                                <div class="row g-1">
                                    <div class="col-6">
                                        <label for="fecha_inicio_bloque_3" class="form-label small fw-semibold">Inicio</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_inicio_bloque_3" name="FECHA_INICIO_BLOQUE_3" required
                                            value="{{ old('FECHA_INICIO_BLOQUE_3') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="fecha_finaliza_bloque_3" class="form-label small fw-semibold">Fin</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_finaliza_bloque_3" name="FECHA_FINALIZA_BLOQUE_3" required
                                            value="{{ old('FECHA_FINALIZA_BLOQUE_3') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="bg-light rounded p-1 mb-1 text-center">
                                    <span class="badge bg-success">Bloque 4</span>
                                </div>
                                <div class="row g-1">
                                    <div class="col-6">
                                        <label for="fecha_inicio_bloque_4" class="form-label small fw-semibold">Inicio</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_inicio_bloque_4" name="FECHA_INICIO_BLOQUE_4" required
                                            value="{{ old('FECHA_INICIO_BLOQUE_4') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="fecha_finaliza_bloque_4" class="form-label small fw-semibold">Fin</label>
                                        <input type="date" class="form-control form-control-sm" 
                                            id="fecha_finaliza_bloque_4" name="FECHA_FINALIZA_BLOQUE_4" required
                                            value="{{ old('FECHA_FINALIZA_BLOQUE_4') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <button type="button" class="btn btn-sm btn-secondary me-2" id="cancelar">
                        <i class="bi bi-x-circle me-1"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-sm btn-success" id="btnGuardar">
                        <i class="bi bi-save me-1"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};        
let ACCION_GLOBAL;

function showError(message) {
    const errorContainer = document.getElementById('errorMessageContainer');
    const errorMessageElement = document.getElementById('errorMessage');
    
    errorMessageElement.textContent = message;
    errorContainer.classList.remove('d-none');
}

function hideError() {
    const errorContainer = document.getElementById('errorMessageContainer');
    errorContainer.classList.add('d-none');
}

function determinarModoFormulario() {
    const rutaActual = window.location.pathname;
    const esModoEdicion = rutaActual.includes('modificar-periodo');
    
    const accion = esModoEdicion ? 'U' : 'I';
    
    return accion;
}

function recopilarDatosPeriodo() {
    // Función auxiliar para verificar si un campo de fecha está vacío
    const getDateValueOrNull = (elementId) => {
        const value = document.getElementById(elementId).value;
        return value ? value : null;
    };
    
    return {
        CODIGO_PERIODO: document.getElementById('codigo_periodo').value,
        DESCRIPCION_PERIODO: document.getElementById('descripcion_periodo').value,
        FECHA_INICIO_PERIODO: getDateValueOrNull('fecha_inicio_periodo'),
        FECHA_FINALIZA_PERIODO: getDateValueOrNull('fecha_finaliza_periodo'),
        FECHA_INICIO_BLOQUE_1: getDateValueOrNull('fecha_inicio_bloque_1'),
        FECHA_FINALIZA_BLOQUE_1: getDateValueOrNull('fecha_finaliza_bloque_1'),
        FECHA_INICIO_BLOQUE_2: getDateValueOrNull('fecha_inicio_bloque_2'),
        FECHA_FINALIZA_BLOQUE_2: getDateValueOrNull('fecha_finaliza_bloque_2'),
        FECHA_INICIO_BLOQUE_3: getDateValueOrNull('fecha_inicio_bloque_3'),
        FECHA_FINALIZA_BLOQUE_3: getDateValueOrNull('fecha_finaliza_bloque_3'),
        FECHA_INICIO_BLOQUE_4: getDateValueOrNull('fecha_inicio_bloque_4'),
        FECHA_FINALIZA_BLOQUE_4: getDateValueOrNull('fecha_finaliza_bloque_4'),
        ESTADO_PERIODO: 'A',
        ID_PERSONA_INGRESO: ID_PERSONA,
        ACCION: ACCION_GLOBAL
    };
}

function recuperarPeriodo() {
    const urlCompleta = window.location.pathname;
    const partes = urlCompleta.split('/');
    const identificador = partes[partes.length - 1]; // Obtiene el último segmento de la URL
    if (!identificador) {
        console.error('No se pudo identificar el período en la URL:', urlCompleta);
        return;
    }
    
    console.log('Identificador obtenido:', identificador);
    
    // Realizar la petición a la API
    fetch(`http://localhost:3000/periodos/${identificador}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los datos del período');
            }
            return response.json();
        })
        .then(responseData => {
            if (!responseData.data || responseData.data.length === 0) {
                console.error('No se encontraron datos para este período');
                return;
            }
            
            // Obtener los datos del período (primer elemento del array data)
            const periodo = responseData.data[0];
            console.log('Datos obtenidos:', periodo);
            
            // Llenar los campos del formulario con los datos obtenidos
            document.getElementById('codigo_periodo').value = periodo.CODIGO_PERIODO || '';
            document.getElementById('descripcion_periodo').value = periodo.DESCRIPCION_PERIODO || '';
            document.getElementById('fecha_inicio_periodo').value = formatearFecha(periodo.FECHA_INICIO_PERIODO);
            document.getElementById('fecha_finaliza_periodo').value = formatearFecha(periodo.FECHA_FINALIZA_PERIODO);
            if (periodo.bloques && Array.isArray(periodo.bloques)) {
                const bloquesPorNumero = {};
                periodo.bloques.forEach(bloque => {
                    bloquesPorNumero[bloque.NUMERO_BLOQUE] = bloque;
                });
                for (let i = 1; i <= 4; i++) {
                    const bloque = bloquesPorNumero[i];
                    if (bloque) {
                        document.getElementById(`fecha_inicio_bloque_${i}`).value = 
                            formatearFecha(bloque.FECHA_INICIO_BLOQUE);
                        document.getElementById(`fecha_finaliza_bloque_${i}`).value = 
                            formatearFecha(bloque.FECHA_FINALIZA_BLOQUE);
                    }
                }
            }
            if (ACCION_GLOBAL === 'U') {
                document.getElementById('codigo_periodo').readOnly = true;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error al recuperar los datos: ' + error.message);
        });
}

// Función auxiliar para formatear fechas desde la API al formato yyyy-MM-dd para inputs date
function formatearFecha(fechaString) {
    if (!fechaString) return '';
    
    // Si la fecha ya está en formato ISO (yyyy-MM-dd), devolverla tal cual
    if (/^\d{4}-\d{2}-\d{2}$/.test(fechaString)) {
        return fechaString;
    }
    
    // Convertir la fecha a formato ISO
    const fecha = new Date(fechaString);
    return fecha.toISOString().split('T')[0];
}


$(document).ready(function () {
    ACCION_GLOBAL = determinarModoFormulario();
    
    if (ACCION_GLOBAL === 'U') {
        recuperarPeriodo();   
        document.getElementById("titulo").textContent = "Modificar Período Académico";
    } else {
        document.getElementById("titulo").textContent = "Agregar Período Académico";
    }
    
    $("#btnGuardar").click(() => {
                
        const datosPeriodo = recopilarDatosPeriodo();
        
        fetch('http://localhost:3000/periodos', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datosPeriodo)
        })
        .then(response => response.json())
        .then(data => {
            // Verificar si hay mensaje de error
            if (data.mensaje && data.mensaje !== "") {
                // Mostrar mensaje de error
                showError(data.mensaje);
            } else {
                // Éxito - mostrar mensaje y/o redirigir
                if (ACCION_GLOBAL === 'U'){
                    window.location.href = '/periodos';    
                } else {
                    document.getElementById('periodoForm').reset();
                    hideError();
                    alert('Período académico guardado correctamente');
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión. Intente nuevamente.');
        });
    });
    
    $("#cancelar").click(() => {    
        window.location.href = '/periodos';
    });    
});
</script>
@endsection