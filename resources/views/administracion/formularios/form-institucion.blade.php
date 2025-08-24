@extends("layouts.header")
@section("contenido")
<link href="/css/form.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0" id="titulo">
                <i class="bi bi-building me-2"></i>Información Institucional
            </h4>
        </div>
        <div class="card-body p-4 bg-light">
            <!-- Mensaje de éxito -->
            <div id="successMessageContainer" class="alert alert-success d-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span id="successMessage">Datos guardados correctamente</span>
                </div>
            </div>

            <form id="institucionForm" class="needs-validation">
                <!-- Información Básica -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-info-circle me-2"></i>Información Básica
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="nombreColegio" class="form-label fw-semibold">
                                    <i class="bi bi-building me-1 text-primary"></i>Nombre del Colegio <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" 
                                       id="nombreColegio" name="NOMBRE_COLEGIO" maxlength="150" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="direccion" class="form-label fw-semibold">
                                    <i class="bi bi-geo-alt me-1 text-primary"></i>Dirección <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" 
                                       id="direccion" name="DIRECCION" maxlength="50" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="departamento" class="form-label fw-semibold">
                                    <i class="bi bi-map me-1 text-primary"></i>Departamento
                                </label>
                                <input type="text" class="form-control" 
                                       id="departamento" name="DEPARTAMENTO" maxlength="50">
                            </div>
                            <div class="col-md-6">
                                <label for="municipio" class="form-label fw-semibold">
                                    <i class="bi bi-pin-map me-1 text-primary"></i>Municipio
                                </label>
                                <input type="text" class="form-control" 
                                       id="municipio" name="MUNICIPIO" maxlength="50">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="zona" class="form-label fw-semibold">
                                    <i class="bi bi-signpost me-1 text-primary"></i>Zona
                                </label>
                                <input type="text" class="form-control" 
                                       id="zona" name="ZONA" maxlength="10">
                            </div>
                            <div class="col-md-6">
                                <label for="telefono" class="form-label fw-semibold">
                                    <i class="bi bi-telephone me-1 text-primary"></i>Teléfono
                                </label>
                                <input type="tel" class="form-control" 
                                       id="telefono" name="TELEFONO" maxlength="20">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1 text-primary"></i>Correo Electrónico
                                </label>
                                <input type="email" class="form-control" 
                                       id="email" name="EMAIL" maxlength="100">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Información Administrativa -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-person-badge me-2"></i>Información Administrativa
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="identificadorDirector" class="form-label fw-semibold">
                                    <i class="bi bi-person-check me-1 text-primary"></i>Director
                                </label>
                                <select class="form-select" id="identificadorDirector" name="IDENTIFICADOR_DIRECTOR">
                                    <option value="" selected>Seleccione un director</option>
                                </select>
                                <small class="text-muted" id="directorActual"></small>
                            </div>
                            <div class="col-md-6">
                                <label for="identificadorSubdirector" class="form-label fw-semibold">
                                    <i class="bi bi-person-plus me-1 text-primary"></i>Subdirector
                                </label>
                                <select class="form-select" id="identificadorSubdirector" name="IDENTIFICADOR_SUBDIRECTOR">
                                    <option value="" selected>Seleccione un subdirector</option>
                                </select>
                                <small class="text-muted" id="subdirectorActual"></small>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nit" class="form-label fw-semibold">
                                    <i class="bi bi-card-text me-1 text-primary"></i>NIT
                                </label>
                                <input type="text" class="form-control" 
                                       id="nit" name="NIT" maxlength="20">
                            </div>
                            <div class="col-md-6">
                                <label for="codigoMineduc" class="form-label fw-semibold">
                                    <i class="bi bi-hash me-1 text-primary"></i>Código MINEDUC
                                </label>
                                <input type="text" class="form-control" 
                                       id="codigoMineduc" name="CODIGO_MINEDUC" maxlength="20">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="button" class="btn btn-primary px-4 py-2" id="btnGuardar">
                        <i class="bi bi-save me-2"></i>Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading overlay -->
<div id="loadingOverlay" class="d-none position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 d-flex justify-content-center align-items-center" style="z-index: 9999;">
    <div class="text-center text-white">
        <div class="spinner-border mb-3" role="status">
            <span class="visually-hidden">Cargando...</span>
        </div>
        <p>Cargando información...</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    // Variables globales
    const apiBaseUrl = 'http://localhost:3000/institucion';
    const administradoresUrl = 'http://localhost:3000/personas/administradores';
    let datosInstitucionCargados = null;
    let administradoresCargados = false;

    // Cargar datos al inicializar
    inicializarFormulario();

    // Event listeners
    $('#btnGuardar').click(function() {
        guardarDatos();
    });

    $('#cancelar').click(function() {
        mostrarConfirmacionCancelar();
    });

    // Ocultar mensajes cuando el usuario empiece a escribir
    $('input, select').on('input change', function() {
        if (!$('#successMessageContainer').hasClass('d-none')) {
            setTimeout(hideMessages, 3000);
        }
    });

    // Función para inicializar el formulario
    function inicializarFormulario() {
        showLoading();
        
        // Cargar administradores y datos de institución en paralelo
        $.when(
            fetchAdministradores(),
            cargarDatosInstitucion()
        ).done(function() {
            // Una vez que ambas llamadas terminan, establecer los valores seleccionados
            establecerValoresSeleccionados();
            hideLoading();
        }).fail(function() {
            hideLoading();
            mostrarErrorGeneral('Error al inicializar el formulario', 'No se pudieron cargar todos los datos necesarios. Por favor, recargue la página.');
        });
    }

    // Función para cargar administradores desde la API
    function fetchAdministradores() {
        return $.ajax({
            url: administradoresUrl,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.data) {
                    populateAdministradoresDropdown(response.data);
                    administradoresCargados = true;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error fetching administradores:', error);
                mostrarErrorCarga('Error al cargar administradores', 'No se pudo cargar la lista de administradores. Algunos campos pueden no estar disponibles.');
            }
        });
    }

    // Función para poblar los dropdowns de administradores
    function populateAdministradoresDropdown(administradores) {
        const directorDropdown = $('#identificadorDirector');
        const subdirectorDropdown = $('#identificadorSubdirector');
        
        // Limpiar opciones existentes excepto la primera
        directorDropdown.find('option:not(:first)').remove();
        subdirectorDropdown.find('option:not(:first)').remove();
        
        // Agregar nuevas opciones
        $.each(administradores, function(index, admin) {
            const option = $('<option>', {
                value: admin.ID_PERSONA,
                text: admin.NOMBRE_COMPLETO
            });
            
            directorDropdown.append(option.clone());
            subdirectorDropdown.append(option.clone());
        });
    }

    // Función para establecer valores seleccionados después de cargar datos
    function establecerValoresSeleccionados() {
        if (datosInstitucionCargados && administradoresCargados) {
            // Establecer valores en los dropdowns
            if (datosInstitucionCargados.IDENTIFICADOR_DIRECTOR) {
                $('#identificadorDirector').val(datosInstitucionCargados.IDENTIFICADOR_DIRECTOR);
            }
            
            if (datosInstitucionCargados.IDENTIFICADOR_SUBDIRECTOR) {
                $('#identificadorSubdirector').val(datosInstitucionCargados.IDENTIFICADOR_SUBDIRECTOR);
            }

            // Mostrar nombres actuales si existen
            if (datosInstitucionCargados.NOMBRE_DIRECTOR) {
                $('#directorActual').html(`<i class="bi bi-person-check-fill text-success me-1"></i>Actual: <strong>${datosInstitucionCargados.NOMBRE_DIRECTOR}</strong>`);
            }

            if (datosInstitucionCargados.NOMBRE_SUBDIRECTOR) {
                $('#subdirectorActual').html(`<i class="bi bi-person-check-fill text-success me-1"></i>Actual: <strong>${datosInstitucionCargados.NOMBRE_SUBDIRECTOR}</strong>`);
            }
        }
    }

    // Función para recopilar datos del formulario
    function recopilarDatosFormulario() {
        return {
            NOMBRE_COLEGIO: $('#nombreColegio').val().trim(),
            DIRECCION: $('#direccion').val().trim(),
            DEPARTAMENTO: $('#departamento').val().trim() || null,
            MUNICIPIO: $('#municipio').val().trim() || null,
            ZONA: $('#zona').val().trim() || null,
            TELEFONO: $('#telefono').val().trim() || null,
            EMAIL: $('#email').val().trim() || null,
            IDENTIFICADOR_DIRECTOR: $('#identificadorDirector').val() ? 
                parseInt($('#identificadorDirector').val()) : null,
            IDENTIFICADOR_SUBDIRECTOR: $('#identificadorSubdirector').val() ? 
                parseInt($('#identificadorSubdirector').val()) : null,
            NIT: $('#nit').val().trim() || null,
            CODIGO_MINEDUC: $('#codigoMineduc').val().trim() || null
        };
    }

    // Función para mostrar errores de validación
    function mostrarErrorValidacion(titulo, mensaje, campo) {
        Swal.fire({
            icon: 'error',
            title: titulo,
            text: mensaje,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Entendido',
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed && campo) {
                $(campo).focus();
            }
        });
    }

    // Función para mostrar errores de carga
    function mostrarErrorCarga(titulo, mensaje) {
        Swal.fire({
            icon: 'warning',
            title: titulo,
            text: mensaje,
            confirmButtonColor: '#ffc107',
            confirmButtonText: 'Continuar',
            allowOutsideClick: false
        });
    }

    // Función para mostrar errores generales
    function mostrarErrorGeneral(titulo, mensaje) {
        Swal.fire({
            icon: 'error',
            title: titulo,
            text: mensaje,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Entendido',
            allowOutsideClick: false
        });
    }

    // Función para mostrar errores de conexión
    function mostrarErrorConexion() {
        Swal.fire({
            icon: 'error',
            title: 'Error de Conexión',
            html: `
                <div class="text-start">
                    <p>No se pudo conectar con el servidor.</p>
                    <div class="alert alert-info mt-3">
                        <small>
                            <strong>Posibles causas:</strong><br>
                            • Problemas de conectividad a internet<br>
                            • El servidor está temporalmente no disponible<br>
                            • Configuración de red incorrecta
                        </small>
                    </div>
                </div>
            `,
            confirmButtonColor: '#dc3545',
            confirmButtonText: 'Reintentar',
            showCancelButton: true,
            cancelButtonText: 'Cancelar',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                // Reintentar la operación
                inicializarFormulario();
            }
        });
    }

    // Función para mostrar confirmación de cancelar
    function mostrarConfirmacionCancelar() {
        Swal.fire({
            icon: 'question',
            title: '¿Cancelar cambios?',
            text: '¿Está seguro de que desea cancelar? Los cambios no guardados se perderán.',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No, continuar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                inicializarFormulario();
                hideMessages();
                Swal.fire({
                    icon: 'info',
                    title: 'Cambios descartados',
                    text: 'Se han restaurado los datos originales.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    }

    // Función para mostrar éxito
    function showSuccess(message) {
        const $successContainer = $('#successMessageContainer');
        const $successMessage = $('#successMessage');
        
        $successMessage.text(message);
        $successContainer.removeClass('d-none');
        
        $successContainer[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    // Función para ocultar mensajes
    function hideMessages() {
        $('#successMessageContainer').addClass('d-none');
    }

    // Función para mostrar loading
    function showLoading() {
        $('#loadingOverlay').removeClass('d-none');
    }

    // Función para ocultar loading
    function hideLoading() {
        $('#loadingOverlay').addClass('d-none');
    }

    // Función para validar formulario
    function validarFormulario() {
        const nombreColegio = $('#nombreColegio').val().trim();
        const direccion = $('#direccion').val().trim();
        
        if (!nombreColegio) {
            mostrarErrorValidacion(
                'Campo Obligatorio',
                'El nombre del colegio es obligatorio.',
                '#nombreColegio'
            );
            return false;
        }
        
        if (!direccion) {
            mostrarErrorValidacion(
                'Campo Obligatorio',
                'La dirección es obligatoria.',
                '#direccion'
            );
            return false;
        }
        
        // Validar email si se proporciona
        const email = $('#email').val().trim();
        if (email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                mostrarErrorValidacion(
                    'Formato Incorrecto',
                    'Por favor, ingrese un correo electrónico válido.',
                    '#email'
                );
                return false;
            }
        }
        
        return true;
    }

    // Función para cargar datos de la institución
    function cargarDatosInstitucion() {
        return $.ajax({
            url: apiBaseUrl + '/',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (data) {
                    // Guardar datos para uso posterior
                    datosInstitucionCargados = data;
                    
                    // Llenar el formulario con los datos existentes
                    $('#nombreColegio').val(data.NOMBRE_COLEGIO || '');
                    $('#direccion').val(data.DIRECCION || '');
                    $('#departamento').val(data.DEPARTAMENTO || '');
                    $('#municipio').val(data.MUNICIPIO || '');
                    $('#zona').val(data.ZONA || '');
                    $('#telefono').val(data.TELEFONO || '');
                    $('#email').val(data.EMAIL || '');
                    $('#nit').val(data.NIT || '');
                    $('#codigoMineduc').val(data.CODIGO_MINEDUC || '');
                    
                    console.log('Datos cargados correctamente:', data);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar datos:', error);
                // No mostrar error si no hay datos (404), puede ser la primera vez
                if (xhr.status !== 404) {
                    mostrarErrorCarga(
                        'Error al cargar datos',
                        'No se pudieron cargar los datos existentes de la institución. Puede continuar ingresando la información manualmente.'
                    );
                }
            }
        });
    }

    // Función para guardar datos
    function guardarDatos() {
        hideMessages();    
        const datosInstitucion = recopilarDatosFormulario();
        
        // Mostrar confirmación antes de guardar
        Swal.fire({
            icon: 'question',
            title: 'Confirmar Guardado',
            text: '¿Está seguro de que desea guardar los cambios en la información institucional?',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check me-2"></i>Sí, guardar',
            cancelButtonText: '<i class="bi bi-x me-2"></i>Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                ejecutarGuardado(datosInstitucion);
            }
        });
    }

    // Función para ejecutar el guardado
    function ejecutarGuardado(datosInstitucion) {
        showLoading();
        
        $.ajax({
            url: apiBaseUrl + '/',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datosInstitucion),
            success: function(response) {
                console.log('Respuesta del servidor:', response);
                
                // Verificar si hay mensaje de error
                if (response.mensaje && response.mensaje.trim() !== "") {
                    mostrarErrorGeneral('Error al Guardar', response.mensaje);
                } else {
                    // Éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado Exitoso!',
                        text: 'Los datos de la institución se han guardado correctamente.',
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Excelente',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        // Recargar datos para mostrar los nombres actualizados
                        inicializarFormulario();
                    });
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                
                if (xhr.status === 0) {
                    mostrarErrorConexion();
                } else if (xhr.status >= 500) {
                    mostrarErrorGeneral(
                        'Error del Servidor',
                        'Ocurrió un error interno en el servidor. Por favor, intente nuevamente más tarde.'
                    );
                } else {
                    mostrarErrorGeneral(
                        'Error Inesperado',
                        'Ocurrió un error inesperado. Por favor, intente nuevamente.'
                    );
                }
            },
            complete: function() {
                hideLoading();
            }
        });
    }
});
</script>

@endsection
