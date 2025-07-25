@extends("layouts.header")
@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-credit-card"></i>
        <span>Administración de Pagos</span>
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
            <div class="row mb-4 align-items-center">
                <!-- Selector de período -->
                <div class="col-md-8 col-lg-8">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="selectPeriodo" class="form-label fw-semibold">Período Escolar</label>
                            <select class="form-select" id="selectPeriodo">
                                <option value="" selected disabled>Seleccione un período</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Botón de agregar -->
                <div class="col-md-4 col-lg-4 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#pagoModal" disabled>
                        <i class="bi bi-plus-circle me-1"></i>Registrar Pago
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaPagos" class="table">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Correlativo</th>
                            <th scope="col">Tipo de Pago</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Monto Pagado</th>
                            <th scope="col">Fecha de Pago</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                    </tbody>
                </table>
                <div id="paginacion" class="mt-3">
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para registrar pago -->
<div class="modal fade custom-modal" id="pagoModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header text-white" style="background-color: #198754;">
                <div class="d-flex align-items-center">
                    <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
                    <h4 class="modal-title" id="titulo">Registrar Pago</h4>
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
                <form id="pagoForm">
                    <input type="hidden" id="alumnoId" name="ID_ALUMNO">
                    <input type="hidden" id="periodoIdModal" name="ID_PERIODO_ESCOLAR">
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Información del Alumno</h5>
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">Alumno</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-user-graduate"></i></span>
                                            <input type="text" class="form-control" id="alumnoSeleccionado" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold">Período Escolar</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                                            <input type="text" class="form-control" id="periodoSeleccionadoModal" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="card border-0 shadow-sm h-100">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Información del Pago</h5>
                                    <div class="mb-4">
                                        <label for="selectPagoDisponible" class="form-label fw-semibold">Pago a Realizar</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-money-bill"></i></span>
                                            <select class="form-select" id="selectPagoDisponible" name="PAGO_SELECCIONADO">
                                                <option value="" selected disabled>Seleccione un pago</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-4">
                                        <label for="montoAPagar" class="form-label fw-semibold">Monto a Pagar</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light">Q</span>
                                            <input type="number" class="form-control" id="montoAPagar" name="MONTO_PAGADO" step="0.01" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="selectMetodoPago" class="form-label fw-semibold">Método de Pago</label>
                                        <div class="input-group input-group-lg">
                                            <span class="input-group-text bg-light"><i class="fas fa-credit-card"></i></span>
                                            <select class="form-select" id="selectMetodoPago" name="METODO_DE_PAGO">
                                                <option value="" selected disabled>Seleccione método de pago</option>
                                                <option value="E">Efectivo</option>
                                                <option value="T">Tarjeta</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="observaciones" class="form-label fw-semibold">Observaciones (Opcional)</label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light"><i class="fas fa-comment"></i></span>
                                            <textarea class="form-control" id="observaciones" name="OBSERVACIONES" rows="3" placeholder="Ingrese observaciones adicionales"></textarea>
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
                    <i class="bi bi-check-circle me-2"></i>Registrar Pago
                </button>
            </div>
        </div>
    </div>
</div>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};
const apiBaseUrl = 'http://localhost:3000/pagos';

// Obtener parámetros de la URL
function getUrlParameters() {
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Buscar el índice de 'pagos' en la URL
    const pagosIndex = segments.indexOf('pagos');
    
    if (pagosIndex !== -1 && segments.length > pagosIndex + 1) {
        return {
            alumno: parseInt(segments[pagosIndex + 1])
        };
    }
    
    return { alumno: null };
}

// Variables globales
let urlParams = getUrlParameters();
let currentPage = 1;
let totalPages = 1;
let currentFilters = {};
let selectedPeriodo = null;
let pagosDisponibles = [];

// Función para generar recibo de pago
function generarRecibo(correlativo) {
    // Obtener el período seleccionado del dropdown como fallback
    const periodoFromDropdown = $('#selectPeriodo').val();
    const periodoToUse = selectedPeriodo || periodoFromDropdown;
    
    console.log('Generando recibo - selectedPeriodo:', selectedPeriodo, 'dropdown:', periodoFromDropdown); // Para debug
    
    if (!periodoToUse) {
        alert('No se ha seleccionado un período');
        return;
    }
    
    // Construir la URL del endpoint
    const reciboUrl = `http://localhost:3000/pdf/recibo/${correlativo}/${periodoToUse}`;
    
    console.log('URL del recibo:', reciboUrl); // Para debug
    
    // Abrir el PDF en una nueva ventana
    window.open(reciboUrl, '_blank');
}

// Cargar información del alumno
function cargarInfoAlumno() {
    if (!urlParams.alumno) {
        console.error('ID de alumno no válido');
        return;
    }
    
    const datos = {
        ID_ALUMNO: urlParams.alumno
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
                document.getElementById('alumnoSeleccionado').value = alumno.NOMBRE_COMPLETO;
                document.getElementById('alumnoId').value = alumno.ID_ALUMNO;
                
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

// Cargar períodos del alumno
function cargarPeriodos() {
    if (!urlParams.alumno) {
        console.error('ID de alumno no válido');
        return;
    }
    
    $.ajax({
        url: `http://localhost:3000/periodos/alumno/${urlParams.alumno}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            populatePeriodosDropdown(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los períodos:', error);
        }
    });
}

// Función para llenar el dropdown de períodos
function populatePeriodosDropdown(periodos) {
    const selectPeriodo = $('#selectPeriodo');
    
    // Limpiar opciones existentes excepto la primera
    selectPeriodo.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(periodos, function(index, periodo) {
        selectPeriodo.append($('<option>', {
            value: periodo.ID_PERIODO_ESCOLAR,
            text: periodo.NOMBRE_PERIODO
        }));
    });
    
    // Seleccionar automáticamente el primer período si hay períodos disponibles
    if (periodos.length > 0) {
        const primerPeriodo = periodos[0];
        selectPeriodo.val(primerPeriodo.ID_PERIODO_ESCOLAR);
        
        // Establecer la variable global ANTES de disparar otros eventos
        selectedPeriodo = parseInt(primerPeriodo.ID_PERIODO_ESCOLAR);
        const periodoTexto = primerPeriodo.NOMBRE_PERIODO;
        
        console.log('Período seleccionado automáticamente:', selectedPeriodo); // Para debug
        
        document.getElementById('periodoSeleccionadoModal').value = periodoTexto;
        document.getElementById('periodoIdModal').value = selectedPeriodo;
        
        // Habilitar botón de agregar
        $("#agregar").prop('disabled', false);
        
        // Cargar pagos del período seleccionado
        cargarPagos();
        cargarPagosDisponibles();
    }
}

// Cargar pagos registrados
function cargarPagos(page = 1) {
    if (!urlParams.alumno || !selectedPeriodo) {
        $('#tablaPagos tbody').html('<tr><td colspan="6" class="text-center">Seleccione un período para ver los pagos</td></tr>');
        return;
    }
    
    const filtros = {
        ID_ALUMNO: urlParams.alumno,
        ID_PERIODO_ESCOLAR: selectedPeriodo,
        ...currentFilters
    };
    
    $.ajax({
        url: `${apiBaseUrl}/filtrar`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(filtros),
        success: function(response) {
            const data = response;
            
            const tbody = $('#tablaPagos tbody');
            tbody.empty();
            
            if (data.length === 0) {
                tbody.append('<tr><td colspan="6" class="text-center">No se encontraron pagos registrados</td></tr>');
            } else {
                data.forEach(pago => {
                    const descripcion = pago.DESCRIPCION_DE_MES ? pago.DESCRIPCION_DE_MES : pago.TIPO_PAGO_DESC;
                    const fila = `
                        <tr>
                            <td>${pago.CORRELATIVO_DE_PAGO}</td>
                            <td>${pago.TIPO_PAGO_DESC}</td>
                            <td>${descripcion}</td>
                            <td>Q ${parseFloat(pago.MONTO_PAGADO).toFixed(2)}</td>
                            <td>${formatDate(pago.FECHA_PAGO)}</td>
                            <td>
                                <button type="button" class="btn btn-outline-primary btn-sm" 
                                        onclick="generarRecibo(${pago.CORRELATIVO_DE_PAGO})"
                                        title="Generar recibo de pago">
                                    <i class="fas fa-receipt me-1"></i>Recibo
                                </button>
                            </td>
                        </tr>
                    `;
                    tbody.append(fila);
                });
            }
        },
        error: function(error) {
            console.error('Error al cargar los pagos:', error);
            $('#tablaPagos tbody').html('<tr><td colspan="6" class="text-center">Error al cargar datos</td></tr>');
        }
    });
}

// Cargar pagos disponibles para el modal
function cargarPagosDisponibles() {
    if (!urlParams.alumno || !selectedPeriodo) {
        return;
    }
    
    const datos = {
        ID_ALUMNO: urlParams.alumno,
        ID_PERIODO_ESCOLAR: selectedPeriodo
    };
    
    $.ajax({
        url: `${apiBaseUrl}/seleccion`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            pagosDisponibles = response;
            populatePagosDisponiblesDropdown(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los pagos disponibles:', error);
        }
    });
}

// Función para llenar el dropdown de pagos disponibles
function populatePagosDisponiblesDropdown(pagos) {
    const selectPago = $('#selectPagoDisponible');
    
    // Limpiar opciones existentes excepto la primera
    selectPago.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(pagos, function(index, pago) {
        const optionText = `${pago.DESCRIPCION_DE_MES} - Q${parseFloat(pago.MONTO).toFixed(2)}`;
        selectPago.append($('<option>', {
            value: index,
            text: optionText,
            'data-tipo': pago.TIPO_PAGO,
            'data-numero': pago.NUMERO,
            'data-monto': pago.MONTO
        }));
    });
}

// Formatear fecha
function formatDate(dateString) {
    if (!dateString) return '';
    const date = new Date(dateString);
    return date.toLocaleDateString('es-ES', { 
        day: '2-digit', 
        month: '2-digit', 
        year: 'numeric' 
    });
}

// Mostrar mensaje de error
function showError(message) {
    const errorContainer = document.getElementById("errorMessageContainer");
    const errorMessageElement = document.getElementById("errorMessage");
    errorMessageElement.textContent = message;
    errorContainer.classList.remove("d-none");
}

// Ocultar mensaje de error
function hideError() {
    const errorContainer = document.getElementById('errorMessageContainer');
    errorContainer.classList.add('d-none');
}

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    // Verificar que tenemos parámetros válidos
    if (!urlParams.alumno) {
        alert('URL no válida. Debe acceder desde /pagos/{id_alumno}');
        return;
    }
    
    // Cargar información inicial
    cargarInfoAlumno();
    cargarPeriodos();
    
    // Evento para cambio de período
    $("#selectPeriodo").change(function() {
        selectedPeriodo = parseInt($(this).val());
        const periodoTexto = $(this).find('option:selected').text();
        
        document.getElementById('periodoSeleccionadoModal').value = periodoTexto;
        document.getElementById('periodoIdModal').value = selectedPeriodo;
        
        // Habilitar botón de agregar
        $("#agregar").prop('disabled', false);
        
        // Cargar pagos del período seleccionado
        cargarPagos();
        cargarPagosDisponibles();
    });
    
    // Botón agregar
    $("#agregar").click(function() {
        hideError();
        $("#selectPagoDisponible").val("");
        $("#montoAPagar").val("");
        $("#selectMetodoPago").val("");
        $("#observaciones").val("");
    });
    
    // Evento para cambio de pago seleccionado
    $("#selectPagoDisponible").change(function() {
        const selectedIndex = $(this).val();
        if (selectedIndex !== "") {
            const pagoSeleccionado = pagosDisponibles[selectedIndex];
            $("#montoAPagar").val(parseFloat(pagoSeleccionado.MONTO).toFixed(2));
        } else {
            $("#montoAPagar").val("");
        }
    });
    
    // Botón guardar
    $("#btnGuardar").click(function() {
        const selectedIndex = $("#selectPagoDisponible").val();
        
        if (!selectedIndex || selectedIndex === "") {
            showError("Debe seleccionar un pago");
            return;
        }
        
        if (!$("#selectMetodoPago").val()) {
            showError("Debe seleccionar un método de pago");
            return;
        }
        
        const pagoSeleccionado = pagosDisponibles[selectedIndex];
        
        const datos = {
            CORRELATIVO_DE_PAGO: null, // Se genera automáticamente
            ID_PERIODO_ESCOLAR: selectedPeriodo,
            ID_ALUMNO: urlParams.alumno,
            TIPO_PAGO: pagoSeleccionado.TIPO_PAGO,
            MES_DE_PAGO: pagoSeleccionado.NUMERO,
            MONTO_PAGADO: parseFloat($("#montoAPagar").val()),
            METODO_DE_PAGO: $("#selectMetodoPago").val(),
            OBSERVACIONES: $("#observaciones").val() || null,
            ACCION: 'I'
        };
        
        console.log('Datos a enviar:', datos); // Para debug
        
        $.ajax({
            url: apiBaseUrl,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            success: function(response) {
                if (response.mensaje === "") {
                    $("#pagoModal").modal("hide");
                    cargarPagos(currentPage);
                    cargarPagosDisponibles(); // Recargar pagos disponibles
                    cargarInfoAlumno(); // Actualizar información del alumno incluyendo solvencia
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
