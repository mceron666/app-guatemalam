@php
    $rolUsuario = Session::get('usuario')['ROL_PERSONA'] ?? null;
    $layout = match($rolUsuario) {
        'G' => 'layouts.header',
        'M' => 'layouts.maestro', 
        'A' => 'layouts.alumnos',
        'P' => 'layouts.header'
    };
@endphp
@extends($layout)
@section("contenido")
<link href="/css/form.css" rel="stylesheet">
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white py-3">
            <h4 class="mb-0" id="titulo">
                <i class="bi bi-person-gear me-2"></i>Cambiar Perfil de Usuario
            </h4>
        </div>
        <div class="card-body p-4 bg-light">
            <!-- Mensaje de éxito -->
            <div id="successMessageContainer" class="alert alert-success d-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <span id="successMessage">Perfil actualizado correctamente</span>
                </div>
            </div>

            <form id="perfilForm" class="needs-validation">
                <!-- Información del Usuario -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-person-circle me-2"></i>Información Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <!-- Campo oculto para ID_PERSONA -->
                        <input type="hidden" id="idPersona" name="ID_PERSONA">
                        
                        <!-- Perfil (solo lectura) -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="perfilPersona" class="form-label fw-semibold">
                                    <i class="bi bi-shield-check me-1 text-primary"></i>Perfil de Usuario
                                </label>
                                <input type="text" class="form-control bg-light" 
                                       id="perfilPersona" name="PERFIL_PERSONA" readonly>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombresPersona" class="form-label fw-semibold">
                                    <i class="bi bi-person me-1 text-primary"></i>Nombres <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                       id="nombresPersona" name="NOMBRES_PERSONA" maxlength="50" required>
                            </div>
                            <div class="col-md-6">
                                <label for="apellidosPersona" class="form-label fw-semibold">
                                    <i class="bi bi-person me-1 text-primary"></i>Apellidos <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                       id="apellidosPersona" name="APELLIDOS_PERSONA" maxlength="50" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="correoPersona" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1 text-primary"></i>Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control"
                                       id="correoPersona" name="CORREO_PERSONA" maxlength="50" required>
                            </div>
                            <div class="col-md-6">
                                <label for="numeroPersona" class="form-label fw-semibold">
                                    <i class="bi bi-telephone me-1 text-primary"></i>Número de Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control"
                                       id="numeroPersona" name="NUMERO_PERSONA" maxlength="15" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Cambio de Contraseña -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-key me-2"></i>Cambio de Contraseña
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Opcional:</strong> Solo complete este campo si desea cambiar su contraseña actual.
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="nuevaClave" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-1 text-primary"></i>Nueva Contraseña
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control"
                                           id="nuevaClave" name="NUEVA_CLAVE" maxlength="64"
                                           placeholder="Deje vacío si no desea cambiar la contraseña">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Mínimo 6 caracteres. Se recomienda usar letras, números y símbolos.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="button" class="btn btn-primary px-4 py-2" id="btnGuardar">
                        <i class="bi bi-save me-2"></i>Guardar Cambios
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
        <p>Procesando información...</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // Variables globales
    const apiBaseUrl = 'http://localhost:3000';
    let datosUsuarioCargados = null;
    let perfilUsuario = null;

    // Obtener perfil del usuario desde el login (asumiendo que está en sessionStorage o localStorage)
    // Ajusta esto según cómo manejes la sesión en tu aplicación
    perfilUsuario = @json(Session::get('usuario')['PERFIL_PERSONA'] ?? null); 
    console.log('Pene', perfilUsuario);

    // Cargar datos al inicializar
    inicializarFormulario();

    // Event listeners
    $('#btnGuardar').click(function() {
        guardarCambios();
    });

    $('#btnCancelar').click(function() {
        mostrarConfirmacionCancelar();
    });

    // Toggle para mostrar/ocultar contraseña
    $('#togglePassword').click(function() {
        const passwordField = $('#nuevaClave');
        const toggleIcon = $('#toggleIcon');
        
        if (passwordField.attr('type') === 'password') {
            passwordField.attr('type', 'text');
            toggleIcon.removeClass('bi-eye').addClass('bi-eye-slash');
        } else {
            passwordField.attr('type', 'password');
            toggleIcon.removeClass('bi-eye-slash').addClass('bi-eye');
        }
    });

    // Ocultar mensajes cuando el usuario empiece a escribir
    $('input').on('input', function() {
        if (!$('#successMessageContainer').hasClass('d-none')) {
            setTimeout(hideMessages, 3000);
        }
    });

    // Función para inicializar el formulario
    function inicializarFormulario() {
        showLoading();
        cargarDatosUsuario();
    }

    // Función para cargar datos del usuario
    function cargarDatosUsuario() {
        const url = `${apiBaseUrl}/personas/${perfilUsuario}`;
        
        $.ajax({
            url: url,
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.data && response.data.length > 0) {
                    datosUsuarioCargados = response.data[0];
                    llenarFormulario(datosUsuarioCargados);
                } else {
                    mostrarErrorGeneral('Usuario No Encontrado', 'No se encontraron datos para el perfil especificado.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar datos del usuario:', error);
                if (xhr.status === 0) {
                    mostrarErrorConexion();
                } else if (xhr.status === 404) {
                    mostrarErrorGeneral('Usuario No Encontrado', 'No se encontró información para el perfil especificado.');
                } else {
                    mostrarErrorGeneral('Error al Cargar Datos', 'No se pudieron cargar los datos del usuario. Por favor, intente nuevamente.');
                }
            },
            complete: function() {
                hideLoading();
            }
        });
    }

    // Función para llenar el formulario con los datos cargados
    function llenarFormulario(datos) {
        $('#idPersona').val(datos.ID_PERSONA);
        $('#perfilPersona').val(datos.PERFIL_PERSONA);
        $('#nombresPersona').val(datos.NOMBRES_PERSONA || '');
        $('#apellidosPersona').val(datos.APELLIDOS_PERSONA || '');
        $('#correoPersona').val(datos.CORREO_PERSONA || '');
        $('#numeroPersona').val(datos.NUMERO_PERSONA || '');
        
        console.log('Datos del usuario cargados:', datos);
    }

    // Función para recopilar datos del formulario
    function recopilarDatosFormulario() {
        const nuevaClave = $('#nuevaClave').val().trim();
        
        return {
            ID_PERSONA: parseInt($('#idPersona').val()),
            NOMBRES_PERSONA: $('#nombresPersona').val().trim(),
            APELLIDOS_PERSONA: $('#apellidosPersona').val().trim(),
            CORREO_PERSONA: $('#correoPersona').val().trim(),
            NUMERO_PERSONA: $('#numeroPersona').val().trim(),
            NUEVA_CLAVE: nuevaClave || null
        };
    }

    // Función para validar formulario
    function validarFormulario() {
        const nombres = $('#nombresPersona').val().trim();
        const apellidos = $('#apellidosPersona').val().trim();
        const correo = $('#correoPersona').val().trim();
        const numero = $('#numeroPersona').val().trim();
        const nuevaClave = $('#nuevaClave').val().trim();

        if (!nombres) {
            mostrarErrorValidacion('Campo Obligatorio', 'Los nombres son obligatorios.', '#nombresPersona');
            return false;
        }

        if (!apellidos) {
            mostrarErrorValidacion('Campo Obligatorio', 'Los apellidos son obligatorios.', '#apellidosPersona');
            return false;
        }

        if (!correo) {
            mostrarErrorValidacion('Campo Obligatorio', 'El correo electrónico es obligatorio.', '#correoPersona');
            return false;
        }

        // Validar formato de email
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(correo)) {
            mostrarErrorValidacion('Formato Incorrecto', 'Por favor, ingrese un correo electrónico válido.', '#correoPersona');
            return false;
        }

        if (!numero) {
            mostrarErrorValidacion('Campo Obligatorio', 'El número de teléfono es obligatorio.', '#numeroPersona');
            return false;
        }

        // Validar contraseña si se proporciona
        if (nuevaClave && nuevaClave.length < 6) {
            mostrarErrorValidacion('Contraseña Muy Corta', 'La nueva contraseña debe tener al menos 6 caracteres.', '#nuevaClave');
            return false;
        }

        return true;
    }

    // Función para guardar cambios
    function guardarCambios() {
        hideMessages();

        if (!validarFormulario()) {
            return;
        }

        const datosFormulario = recopilarDatosFormulario();

        // Mostrar confirmación antes de guardar
        Swal.fire({
            icon: 'question',
            title: 'Confirmar Cambios',
            text: '¿Está seguro de que desea guardar los cambios en su perfil?',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-check me-2"></i>Sí, guardar',
            cancelButtonText: '<i class="bi bi-x me-2"></i>Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                ejecutarGuardado(datosFormulario);
            }
        });
    }

    // Función para ejecutar el guardado
    function ejecutarGuardado(datosFormulario) {
        showLoading();

        $.ajax({
            url: `${apiBaseUrl}/login/cambiar-perfil`,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datosFormulario),
            success: function(response) {
                console.log('Respuesta del servidor:', response);

                // Verificar si hay mensaje de error
                if (response.mensaje && response.mensaje.trim() !== "" && response.mensaje !== "Perfil actualizado correctamente") {
                    mostrarErrorGeneral('Error al Actualizar', response.mensaje);
                } else {
                    // Éxito
                    Swal.fire({
                        icon: 'success',
                        title: '¡Perfil Actualizado!',
                        text: 'Los cambios en su perfil se han guardado correctamente.',
                        confirmButtonColor: '#198754',
                        confirmButtonText: 'Excelente',
                        timer: 3000,
                        timerProgressBar: true
                    }).then(() => {
                        // Limpiar campo de contraseña por seguridad
                        $('#nuevaClave').val('');
                        // Recargar datos actualizados
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
                $('#nuevaClave').val(''); // Limpiar contraseña
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

    // Funciones de utilidad (mismas que en el código original)
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
                inicializarFormulario();
            }
        });
    }

    function showSuccess(message) {
        const $successContainer = $('#successMessageContainer');
        const $successMessage = $('#successMessage');

        $successMessage.text(message);
        $successContainer.removeClass('d-none');

        $successContainer[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function hideMessages() {
        $('#successMessageContainer').addClass('d-none');
    }

    function showLoading() {
        $('#loadingOverlay').removeClass('d-none');
    }

    function hideLoading() {
        $('#loadingOverlay').addClass('d-none');
    }
});
</script>
@endsection