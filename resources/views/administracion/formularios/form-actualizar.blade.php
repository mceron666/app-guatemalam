@extends("layouts.header")
@section("contenido")
<link href="/css/form.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-warning text-dark py-3">
            <h4 class="mb-0">
                <i class="bi bi-calculator me-2"></i>Actualizar Resultados Académicos
            </h4>
        </div>
        <div class="card-body p-4 bg-light">
            <!-- Información del Período -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-warning">
                        <i class="bi bi-calendar-check me-2"></i>Período Escolar a Actualizar
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="bi bi-hash me-1"></i>Código del Período:
                                </label>
                                <div class="info-value">
                                    @php
                                        $codigoPeriodo = Session::get('usuario')['CODIGO_PERIODO'] ?? 'No disponible';
                                    @endphp
                                    <span class="badge bg-primary fs-6">{{ $codigoPeriodo }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-item">
                                <label class="form-label fw-semibold text-muted">
                                    <i class="bi bi-info-circle me-1"></i>Descripción:
                                </label>
                                <div class="info-value">
                                    @php
                                        $descripcionPeriodo = Session::get('usuario')['DESCRIPCION_PERIODO'] ?? 'No disponible';
                                    @endphp
                                    <span class="text-dark fw-semibold">{{ $descripcionPeriodo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Advertencia -->
            <div class="alert alert-warning border-0 mb-4">
                <div class="d-flex align-items-start">
                    <i class="bi bi-exclamation-triangle-fill me-3 fs-4 text-warning"></i>
                    <div>
                        <h6 class="fw-bold mb-2">⚠️ Advertencia Importante</h6>
                        <p class="mb-2">
                            Al proceder con la actualización de resultados:
                        </p>
                        <ul class="mb-0">
                            <li>Se recalcularán <strong>todos los resultados académicos</strong> del período seleccionado</li>
                            <li>Los datos existentes serán <strong>reemplazados completamente</strong></li>
                            <li>Esta acción afectará a <strong>todos los grados y alumnos</strong> del período</li>
                            <li>El proceso <strong>no se puede deshacer</strong> una vez iniciado</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card mb-4 border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0 text-info">
                        <i class="bi bi-info-square me-2"></i>¿Qué hace esta actualización?
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="bi bi-arrow-clockwise text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2 fw-semibold">Recalcula Notas</h6>
                                <p class="text-muted small">Procesa todas las calificaciones registradas</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="bi bi-check-circle text-success" style="font-size: 2rem;"></i>
                                <h6 class="mt-2 fw-semibold">Determina Estados</h6>
                                <p class="text-muted small">Clasifica alumnos: Ganadores, Perdedores, Recuperación</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center mb-3">
                                <i class="bi bi-file-earmark-text text-info" style="font-size: 2rem;"></i>
                                <h6 class="mt-2 fw-semibold">Genera Resumen</h6>
                                <p class="text-muted small">Crea estadísticas por grado y sección</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                <button type="button" class="btn btn-secondary me-md-2 px-4 py-2" id="btnVolver">
                    <i class="bi bi-arrow-left me-2"></i>Volver
                </button>
                <button type="button" class="btn btn-warning px-4 py-2" id="btnActualizar">
                    <i class="bi bi-arrow-clockwise me-2"></i>Actualizar Resultados
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Resumen -->
<div class="modal fade" id="resumenModal" tabindex="-1" aria-labelledby="resumenModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="resumenModalLabel">
                    <i class="bi bi-check-circle me-2"></i>Actualización Completada
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-success border-0 mb-4">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2 fs-5"></i>
                        <div>
                            <strong>¡Actualización exitosa!</strong><br>
                            Los resultados académicos han sido procesados correctamente.
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold mb-3">
                    <i class="bi bi-bar-chart me-2"></i>Resumen por Grado:
                </h6>
                
                <div class="table-responsive">
                    <table class="table table-striped table-hover" id="tablaResumen">
                        <thead class="table-dark">
                            <tr>
                                <th><i class="bi bi-hash me-1"></i>Código</th>
                                <th><i class="bi bi-mortarboard me-1"></i>Grado</th>
                                <th class="text-success"><i class="bi bi-trophy me-1"></i>Ganadores</th>
                                <th class="text-danger"><i class="bi bi-x-circle me-1"></i>Perdedores</th>
                                <th class="text-warning"><i class="bi bi-arrow-repeat me-1"></i>Recuperación</th>
                                <th><i class="bi bi-people me-1"></i>Total</th>
                            </tr>
                        </thead>
                        <tbody id="cuerpoTablaResumen">
                            <!-- Se llenará dinámicamente -->
                        </tbody>
                        <tfoot class="table-secondary">
                            <tr id="filaTotal">
                                <!-- Se llenará dinámicamente -->
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">
                    <i class="bi bi-check me-2"></i>Entendido
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Loading overlay -->
<div id="loadingOverlay" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center" style="z-index: 9999;">
    <div class="text-center text-white">
        <div class="spinner-border mb-3" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Procesando...</span>
        </div>
        <h5>Actualizando Resultados...</h5>
        <p>Por favor espere, este proceso puede tomar unos momentos.</p>
    </div>
</div>

<style>
.info-item {
    margin-bottom: 1rem;
}

.info-value {
    margin-top: 0.5rem;
}

.table th {
    font-size: 0.9rem;
    font-weight: 600;
}

.table td {
    vertical-align: middle;
}

.badge-count {
    font-size: 0.9rem;
    padding: 0.5rem 0.75rem;
    border-radius: 0.5rem;
}
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Variables globales
    const PERIODO_ESCOLAR = {{ Session::get('usuario')['PERIODO_ESCOLAR'] ?? 'null' }};
    const CODIGO_PERIODO = "{{ Session::get('usuario')['CODIGO_PERIODO'] ?? '' }}";
    const apiBaseUrl = 'http://localhost:3000/notas/actualizar';

    // Event listeners
    $('#btnVolver').click(function() {
        window.history.back();
    });

    $('#btnActualizar').click(function() {
        mostrarConfirmacion();
    });

    // Función para mostrar loading
    function showLoading() {
        $('#loadingOverlay').removeClass('d-none');
    }

    // Función para ocultar loading
    function hideLoading() {
        $('#loadingOverlay').addClass('d-none');
    }

    // Función para mostrar confirmación
    function mostrarConfirmacion() {
        Swal.fire({
            icon: 'warning',
            title: '⚠️ Confirmar Actualización',
            html: `
                <div class="text-start">
                    <p><strong>¿Está seguro de que desea actualizar los resultados?</strong></p>
                    <div class="alert alert-warning mt-3">
                        <small>
                            <strong>Esta acción:</strong><br>
                            • Reemplazará todos los resultados existentes<br>
                            • Afectará a todos los grados del período <strong>${CODIGO_PERIODO}</strong><br>
                            • No se puede deshacer una vez completada
                        </small>
                    </div>
                </div>
            `,
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check me-2"></i>Sí, Actualizar',
            cancelButtonText: '<i class="bi bi-x me-2"></i>Cancelar',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                actualizarResultados();
            }
        });
    }

    // Función para actualizar resultados
    function actualizarResultados() {
        if (!PERIODO_ESCOLAR) {
            mostrarError('No se pudo obtener el período escolar de la sesión.');
            return;
        }

        showLoading();

        $.ajax({
            url: `${apiBaseUrl}/${PERIODO_ESCOLAR}`,
            type: 'POST',
            contentType: 'application/json',
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                
                // Verificar si hay mensaje de error
                if (response.mensaje && response.mensaje.trim() !== "") {
                    mostrarError(response.mensaje);
                } else {
                    // Éxito - mostrar resumen
                    if (response.resumen && response.resumen.length > 0) {
                        mostrarResumen(response.resumen);
                    } else {
                        mostrarExito('Los resultados han sido actualizados correctamente.');
                    }
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                mostrarError('No se pudo conectar con el servidor. Por favor, intente nuevamente.');
            },
            complete: function() {
                hideLoading();
            }
        });
    }

    // Función para mostrar error con SweetAlert
    function mostrarError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error en la Actualización',
            text: mensaje,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Entendido'
        });
    }

    // Función para mostrar éxito con SweetAlert
    function mostrarExito(mensaje) {
        Swal.fire({
            icon: 'success',
            title: '¡Actualización Completada!',
            text: mensaje,
            confirmButtonColor: '#198754'
        });
    }

    // Función para mostrar resumen en modal
    function mostrarResumen(resumen) {
        const $cuerpoTabla = $('#cuerpoTablaResumen');
        const $filaTotal = $('#filaTotal');
        
        // Limpiar tabla
        $cuerpoTabla.empty();
        
        let totalGanadores = 0;
        let totalPerdedores = 0;
        let totalRecuperan = 0;
        let totalAlumnos = 0;
        
        // Llenar filas de datos
        $.each(resumen, function(index, grado) {
            const ganadores = parseInt(grado.GANADORES) || 0;
            const perdedores = parseInt(grado.PERDEDORES) || 0;
            const recuperan = parseInt(grado.RECUPERAN) || 0;
            const total = ganadores + perdedores + recuperan;
            
            totalGanadores += ganadores;
            totalPerdedores += perdedores;
            totalRecuperan += recuperan;
            totalAlumnos += total;
            
            const fila = `
                <tr>
                    <td><span class="badge bg-secondary">${grado.CODIGO_GRADO}</span></td>
                    <td class="fw-semibold">${grado.NOMBRE_GRADO}</td>
                    <td class="text-center">
                        <span class="badge bg-success badge-count">${ganadores}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-danger badge-count">${perdedores}</span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-warning badge-count">${recuperan}</span>
                    </td>
                    <td class="text-center fw-bold">${total}</td>
                </tr>
            `;
            $cuerpoTabla.append(fila);
        });
        
        // Llenar fila de totales
        const filaTotales = `
            <td colspan="2" class="fw-bold text-end">TOTALES:</td>
            <td class="text-center">
                <span class="badge bg-success badge-count fs-6">${totalGanadores}</span>
            </td>
            <td class="text-center">
                <span class="badge bg-danger badge-count fs-6">${totalPerdedores}</span>
            </td>
            <td class="text-center">
                <span class="badge bg-warning badge-count fs-6">${totalRecuperan}</span>
            </td>
            <td class="text-center fw-bold fs-5">${totalAlumnos}</td>
        `;
        $filaTotal.html(filaTotales);
        
        // Mostrar modal
        $('#resumenModal').modal('show');
    }

    // Validar datos de sesión al cargar
    if (!PERIODO_ESCOLAR) {
        mostrarError('No se pudo obtener el período escolar de la sesión.');
        $('#btnActualizar').prop('disabled', true);
    }
});
</script>

@endsection