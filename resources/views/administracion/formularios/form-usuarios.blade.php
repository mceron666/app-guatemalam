@extends("layouts.header")
@section("contenido")
<link href="/css/form.css" rel="stylesheet">

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0" id="titulo">
                <i class="bi bi-person-plus-fill me-2"></i>Agregar Persona
            </h4>
        </div>
        <div class="card-body p-4 bg-light">
            <form id="personaForm" class="needs-validation">
                <!-- Información Personal -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-success">
                            <i class="bi bi-person me-2"></i>Información Personal
                        </h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="rol" class="form-label fw-semibold">
                                    <i class="bi bi-person-rolodex me-1 text-success"></i>Rol <span class="text-danger">*</span>
                                </label>
                                <select class="form-select"
                                        id="rol" name="ROL_PERSONA" required onchange="mostrarCamposPorRol()">
                                    <option value="" selected disabled>Seleccione un rol</option>
                                    <option value="G" {{ old('ROL_PERSONA') == 'G' ? 'selected' : '' }}>Administrador</option>
                                    <option value="M" {{ old('ROL_PERSONA') == 'M' ? 'selected' : '' }}>Maestro</option>
                                    <option value="A" {{ old('ROL_PERSONA') == 'A' ? 'selected' : '' }}>Alumno</option>
                                    <option value="P" {{ old('ROL_PERSONA') == 'P' ? 'selected' : '' }}>Maestro administrador</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombres" class="form-label fw-semibold">
                                    <i class="bi bi-type me-1 text-success"></i>Nombres <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                       id="nombres" name="NOMBRES_PERSONA" maxlength="50" required
                                       value="{{ old('NOMBRES_PERSONA') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="apellidos" class="form-label fw-semibold">
                                    <i class="bi bi-type me-1 text-success"></i>Apellidos <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                       id="apellidos" name="APELLIDOS_PERSONA" maxlength="50" required
                                       value="{{ old('APELLIDOS_PERSONA') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="perfil" class="form-label fw-semibold">
                                    <i class="bi bi-person-badge me-1 text-success"></i>Perfil <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control"
                                       id="perfil" name="PERFIL_PERSONA" maxlength="20" required
                                       value="{{ old('PERFIL_PERSONA') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="correo" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-1 text-success"></i>Correo Electrónico <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control"
                                       id="correo" name="CORREO_PERSONA" maxlength="50" required
                                       value="{{ old('CORREO_PERSONA') }}">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    <i class="bi bi-gender-ambiguous me-1 text-success"></i>Sexo <span class="text-danger">*</span>
                                </label>
                                <div class="d-flex mt-2">
                                    <div class="form-check me-4">
                                        <input class="form-check-input" type="radio" name="SEXO_PERSONA"
                                               id="sexoM" value="M" {{ old('SEXO_PERSONA') == 'M' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="sexoM">
                                            <i class="bi bi-gender-male me-1 text-success"></i>Masculino
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="SEXO_PERSONA"
                                               id="sexoF" value="F" {{ old('SEXO_PERSONA') == 'F' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="sexoF">
                                            <i class="bi bi-gender-female me-1 text-success"></i>Femenino
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="numero" class="form-label fw-semibold">
                                    <i class="bi bi-telephone me-1 text-success"></i>Número de Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control"
                                       id="numero" name="NUMERO_PERSONA" maxlength="15" required
                                       value="{{ old('NUMERO_PERSONA') }}">
                            </div>
                        </div>
                        <div class="row">
                            <!-- Campos ocultos -->
                            <input type="hidden" name="ID_PERSONA_INGRESO" value="1">
                            <input type="hidden" name="ACCION" value="I">
                        </div>
                    </div>
                </div>
                <!-- Campos para Maestro (M y P) -->
                <div id="camposMaestro" style="display: none;">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 text-success">
                                <i class="bi bi-mortarboard me-2"></i>Información de Maestro
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="especialidad" class="form-label fw-semibold">
                                        <i class="bi bi-book me-1 text-success"></i>Especialidad <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="especialidad" name="ESPECIALIDAD" maxlength="50"
                                           value="{{ old('ESPECIALIDAD') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="titulo" class="form-label fw-semibold">
                                        <i class="bi bi-award me-1 text-success"></i>Título Académico <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="tituloacademico" name="TITULO_ACADEMICO" maxlength="100"
                                           value="{{ old('TITULO_ACADEMICO') }}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="salario" class="form-label fw-semibold">
                                        <i class="bi bi-cash-coin me-1 text-success"></i>Salario Actual <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-success text-white">Q</span>
                                        <input type="number" step="0.01" min="0"
                                               class="form-control"
                                               id="salario" name="SALARIO_ACTUAL"
                                               value="{{ old('SALARIO_ACTUAL') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="dpi" class="form-label fw-semibold">
                                        <i class="bi bi-card-text me-1 text-success"></i>Número DPI <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="dpi" name="NUMERO_DPI" maxlength="13"
                                           value="{{ old('NUMERO_DPI') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Campos para Alumno (A) -->
                <div id="camposAlumno" style="display: none;">
                    <div class="card mb-4 border-0 shadow-sm">
                        <div class="card-header bg-white">
                            <h5 class="mb-0 text-success">
                                <i class="bi bi-backpack me-2"></i>Información de Alumno
                            </h5>
                        </div>
                        <div class="card-body p-4">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <div class="alert alert-success d-flex align-items-center" role="alert">
                                        <i class="bi bi-info-circle-fill me-2 fs-5"></i>
                                        <div>
                                            Ingrese la información de contacto para emergencias.
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre_contacto_1" class="form-label fw-semibold">
                                        <i class="bi bi-person-check me-1 text-success"></i>Nombre de Contacto 1 <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control"
                                           id="nombre_contacto_1" name="NOMBRE_CONTACTO_1" maxlength="100"
                                           value="{{ old('NOMBRE_CONTACTO_1') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_contacto_1" class="form-label fw-semibold">
                                        <i class="bi bi-telephone me-1 text-success"></i>Número de Contacto 1 <span class="text-danger">*</span>
                                    </label>
                                    <input type="tel" class="form-control"
                                           id="numero_contacto_1" name="NUMERO_CONTACTO_1" maxlength="15"
                                           value="{{ old('NUMERO_CONTACTO_1') }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre_contacto_2" class="form-label fw-semibold">
                                        <i class="bi bi-person-check me-1 text-success"></i>Nombre de Contacto 2
                                    </label>
                                    <input type="text" class="form-control"
                                           id="nombre_contacto_2" name="NOMBRE_CONTACTO_2" maxlength="100"
                                           value="{{ old('NOMBRE_CONTACTO_2') }}">
                                </div>
                                <div class="col-md-6">
                                    <label for="numero_contacto_2" class="form-label fw-semibold">
                                        <i class="bi bi-telephone me-1 text-success"></i>Número de Contacto 2
                                    </label>
                                    <input type="tel" class="form-control"
                                           id="numero_contacto_2" name="NUMERO_CONTACTO_2" maxlength="15"
                                           value="{{ old('NUMERO_CONTACTO_2') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <button type="button" class="btn btn-secondary me-md-2 px-4 py-2" id="cancelar">
                        <i class="bi bi-x-circle me-2"></i>Cancelar
                    </button>
                    <button type="button" class="btn btn-success px-4 py-2" id="btnGuardar">
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
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};
let ACCION_GLOBAL;
const apiBaseUrl = 'http://localhost:3000/personas';

function mostrarCamposPorRol() {
    const rol = document.getElementById('rol').value;
    const camposMaestro = document.getElementById('camposMaestro');
    const camposAlumno = document.getElementById('camposAlumno');

    // Reset required attributes for all fields in both sections
    $('#camposMaestro input, #camposMaestro select').prop('required', false);
    $('#camposAlumno input, #camposAlumno select').prop('required', false);

    camposMaestro.style.display = 'none';
    camposAlumno.style.display = 'none';

    if (rol === 'M' || rol === 'P') {
        camposMaestro.style.display = 'block';
        // Set required for maestro fields
        $('#especialidad, #tituloacademico, #salario, #dpi').prop('required', true);
    } else if (rol === 'A') {
        camposAlumno.style.display = 'block';
        // Set required for alumno fields
        $('#nombre_contacto_1, #numero_contacto_1').prop('required', true);
    }
}

function recopilarDatosFormulario() {
    const datosPersona = {
        ID_PERSONA_INGRESO: ID_PERSONA,
        ACCION: ACCION_GLOBAL,
        NOMBRES_PERSONA: document.getElementById('nombres').value.trim(),
        APELLIDOS_PERSONA: document.getElementById('apellidos').value.trim(),
        CORREO_PERSONA: document.getElementById('correo').value.trim(),
        PERFIL_PERSONA: document.getElementById('perfil').value.trim(),
        NUMERO_PERSONA: document.getElementById('numero').value.trim(),
        ROL_PERSONA: document.getElementById('rol').value,
        SEXO_PERSONA: document.querySelector('input[name="SEXO_PERSONA"]:checked')?.value || '',
        ESPECIALIDAD: '',
        TITULO_ACADEMICO: '',
        SALARIO_ACTUAL: 0,
        NUMERO_DPI: '',
        NOMBRE_CONTACTO_1: '',
        NUMERO_CONTACTO_1: '',
        NOMBRE_CONTACTO_2: '',
        NUMERO_CONTACTO_2: ''
    };

    const rol = datosPersona.ROL_PERSONA;
    if (rol === 'M' || rol === 'P') {
        datosPersona.ESPECIALIDAD = document.getElementById('especialidad').value.trim();
        datosPersona.TITULO_ACADEMICO = document.getElementById('tituloacademico').value.trim();
        datosPersona.SALARIO_ACTUAL = parseFloat(document.getElementById('salario').value) || 0;
        datosPersona.NUMERO_DPI = document.getElementById('dpi').value.trim();
    }
    if (rol === 'A') {
        datosPersona.NOMBRE_CONTACTO_1 = document.getElementById('nombre_contacto_1').value.trim();
        datosPersona.NUMERO_CONTACTO_1 = document.getElementById('numero_contacto_1').value.trim();
        datosPersona.NOMBRE_CONTACTO_2 = document.getElementById('nombre_contacto_2').value.trim() || null;
        datosPersona.NUMERO_CONTACTO_2 = document.getElementById('numero_contacto_2').value.trim() || null;
    }

    return datosPersona;
}

function determinarModoFormulario() {
    const rutaActual = window.location.pathname;
    const esModoEdicion = rutaActual.includes('modificar-usuario');
    
    const accion = esModoEdicion ? 'U' : 'I';
    if (esModoEdicion) {
        document.getElementById('rol').disabled = true;
        document.getElementById('perfil').readOnly = true;
        document.getElementById('sexoM').disabled = true;
        document.getElementById('sexoF').disabled = true;
        
        // Add event listener for DPI protection after initial load
        document.getElementById('rol').addEventListener('change', protegerCamposDPI);
        protegerCamposDPI(); // Call initially
    }
    
    return accion;
}

function protegerCamposDPI() {
    const rol = document.getElementById('rol').value;
    const dpiField = document.getElementById('dpi');
    if (dpiField) {
        // If in update mode and role is Maestro/Maestro Admin, make DPI readOnly
        if ((rol === 'M' || rol === 'P') && ACCION_GLOBAL === 'U') {
            dpiField.readOnly = true;
        } else {
            dpiField.readOnly = false; // Ensure it's editable if not in this specific condition
        }
    }
}

function recuperarPersona() {
    showLoading();
    const urlCompleta = window.location.pathname;
    const partes = urlCompleta.split('/');
    const identificador = partes[partes.length - 1];

    if (!identificador || identificador === 'modificar-usuario') { // Check for empty or just the base path
        console.error('No se pudo identificar el usuario en la URL:', urlCompleta);
        mostrarPersonaNoEncontradaSwal('No disponible');
        hideLoading();
        return;
    }

    fetch(`${apiBaseUrl}/${identificador}`)
        .then(response => {
            if (!response.ok) {
                if (response.status === 404) {
                    throw new Error('Persona no encontrada');
                }
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            return response.json();
        })
        .then(responseData => {
            if (!responseData.data || responseData.data.length === 0) {
                console.error('No se encontraron datos para esta persona');
                mostrarPersonaNoEncontradaSwal(identificador);
                return;
            }
            const persona = responseData.data[0];
            llenarFormularioConDatos(persona);
            hideLoading();
        })
        .catch(error => {
            console.error('Error al recuperar persona:', error);
            hideLoading();
            if (error.message === 'Persona no encontrada') {
                mostrarPersonaNoEncontradaSwal(identificador);
            } else if (error.message.includes('Failed to fetch')) {
                mostrarErrorConexion();
            } else {
                mostrarErrorGeneral('Error de Carga', 'No se pudieron cargar los datos de la persona. ' + error.message);
            }
        });
}

function llenarFormularioConDatos(persona) {
    document.getElementById('nombres').value = persona.NOMBRES_PERSONA || '';
    document.getElementById('apellidos').value = persona.APELLIDOS_PERSONA || '';
    document.getElementById('perfil').value = persona.PERFIL_PERSONA || '';
    document.getElementById('correo').value = persona.CORREO_PERSONA || '';
    document.getElementById('numero').value = persona.NUMERO_PERSONA || '';
    
    const selectRol = document.getElementById('rol');
    selectRol.value = persona.ROL_PERSONA || '';
    mostrarCamposPorRol(); // Update visibility based on loaded role
    
    if (persona.SEXO_PERSONA === 'M') {
        document.getElementById('sexoM').checked = true;
    } else if (persona.SEXO_PERSONA === 'F') {
        document.getElementById('sexoF').checked = true;
    }
    
    if (persona.ROL_PERSONA === 'M' || persona.ROL_PERSONA === 'P') {
        document.getElementById('especialidad').value = persona.ESPECIALIDAD || '';
        document.getElementById('tituloacademico').value = persona.TITULO_ACADEMICO || '';
        document.getElementById('salario').value = persona.SALARIO_ACTUAL || '';
        document.getElementById('dpi').value = persona.NUMERO_DPI || '';
    }
    
    if (persona.ROL_PERSONA === 'A') {
        document.getElementById('nombre_contacto_1').value = persona.NOMBRE_CONTACTO_1 || '';
        document.getElementById('numero_contacto_1').value = persona.NUMERO_CONTACTO_1 || '';
        document.getElementById('nombre_contacto_2').value = persona.NOMBRE_CONTACTO_2 || '';
        document.getElementById('numero_contacto_2').value = persona.NUMERO_CONTACTO_2 || '';
    }
}

// --- SweetAlert Helper Functions ---

function showLoading() {
    $('#loadingOverlay').removeClass('d-none');
}

function hideLoading() {
    $('#loadingOverlay').addClass('d-none');
}

function mostrarExito(mensaje, titulo = 'Operación Exitosa!') {
    Swal.fire({
        icon: 'success',
        title: titulo,
        text: mensaje,
        confirmButtonColor: '#198754',
        confirmButtonText: 'Excelente',
        timer: 3000,
        timerProgressBar: true
    });
}

function mostrarError(titulo, mensaje) {
    Swal.fire({
        icon: 'error',
        title: titulo,
        text: mensaje,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Entendido'
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
            // Reintentar la operación que causó el error de conexión
            // For this form, it's usually loading or saving.
            if (ACCION_GLOBAL === 'U') {
                recuperarPersona();
            } else {
                // If it was a save operation, re-enable save button and let user try again
                $('#btnGuardar').prop('disabled', false);
            }
        }
    });
}

function mostrarErrorValidacion(titulo, mensaje, campoId = null) {
    Swal.fire({
        icon: 'error',
        title: titulo,
        text: mensaje,
        confirmButtonColor: '#dc3545',
        confirmButtonText: 'Entendido',
        allowOutsideClick: false
    }).then(() => {
        if (campoId) {
            $(`#${campoId}`).focus();
        }
    });
}

function mostrarConfirmacion(titulo, htmlContent, confirmText, cancelText, confirmColor, cancelColor, callback) {
    Swal.fire({
        icon: 'question',
        title: titulo,
        html: htmlContent,
        showCancelButton: true,
        confirmButtonColor: confirmColor,
        cancelButtonColor: cancelColor,
        confirmButtonText: confirmText,
        cancelButtonText: cancelText,
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

function mostrarPersonaNoEncontradaSwal(identificador) {
    Swal.fire({
        icon: 'error',
        title: 'Persona No Encontrada',
        html: `
            <div class="text-start">
                <p class="text-danger fw-bold mb-3">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    No se pudo encontrar la persona solicitada
                </p>
                <p class="text-muted lead mb-4">
                    La persona con ID <strong>${identificador}</strong> que está intentando modificar no existe en el sistema o ha sido eliminada.
                </p>
                <div class="alert alert-danger border-0 mb-4">
                    <div class="row text-start">
                        <div class="col-12 mb-3">
                            <h6 class="fw-bold text-danger mb-2">
                                <i class="bi bi-info-circle me-2"></i>Posibles causas:
                            </h6>
                        </div>
                        <div class="col-12">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="bi bi-dot text-danger fs-4 me-1"></i>
                                    <span>El ID de la persona es incorrecto</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-dot text-danger fs-4 me-1"></i>
                                    <span>La persona fue eliminada del sistema</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-dot text-danger fs-4 me-1"></i>
                                    <span>No tiene permisos para acceder a esta información</span>
                                </li>
                                <li>
                                    <i class="bi bi-dot text-danger fs-4 me-1"></i>
                                    <span>Error temporal en la conexión con la base de datos</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="bg-light rounded p-4 mb-4 text-center">
                    <strong class="text-muted">ID solicitado:</strong>
                    <span class="badge bg-secondary ms-2">${identificador}</span>
                    <br>
                    <strong class="text-muted">Fecha del error:</strong>
                    <span class="text-dark ms-2">${new Date().toLocaleString('es-ES')}</span>
                </div>
            </div>
        `,
        showCancelButton: false,
        confirmButtonColor: '#0d6efd',
        confirmButtonText: '<i class="bi bi-arrow-left me-2"></i>Volver a la Lista',
        allowOutsideClick: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/usuarios';
        }
    });
}

// --- Form Validation ---
function validarFormulario() {
    const rol = $('#rol').val();
    const nombres = $('#nombres').val().trim();
    const apellidos = $('#apellidos').val().trim();
    const perfil = $('#perfil').val().trim();
    const correo = $('#correo').val().trim();
    const numero = $('#numero').val().trim();
    const sexo = $('input[name="SEXO_PERSONA"]:checked').val();

    if (!rol) {
        mostrarErrorValidacion('Campo Obligatorio', 'Por favor, seleccione un rol.', 'rol');
        return false;
    }
    if (!nombres) {
        mostrarErrorValidacion('Campo Obligatorio', 'Los nombres son obligatorios.', 'nombres');
        return false;
    }
    if (!apellidos) {
        mostrarErrorValidacion('Campo Obligatorio', 'Los apellidos son obligatorios.', 'apellidos');
        return false;
    }
    if (!perfil) {
        mostrarErrorValidacion('Campo Obligatorio', 'El perfil es obligatorio.', 'perfil');
        return false;
    }
    if (!correo) {
        mostrarErrorValidacion('Campo Obligatorio', 'El correo electrónico es obligatorio.', 'correo');
        return false;
    }
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (correo && !emailRegex.test(correo)) {
        mostrarErrorValidacion('Formato Incorrecto', 'Por favor, ingrese un correo electrónico válido.', 'correo');
        return false;
    }
    if (!numero) {
        mostrarErrorValidacion('Campo Obligatorio', 'El número de teléfono es obligatorio.', 'numero');
        return false;
    }
    if (!sexo) {
        mostrarErrorValidacion('Campo Obligatorio', 'Por favor, seleccione el sexo.', 'sexoM'); // Focus on first radio
        return false;
    }

    // Validaciones específicas por rol
    if (rol === 'M' || rol === 'P') {
        const especialidad = $('#especialidad').val().trim();
        const tituloacademico = $('#tituloacademico').val().trim();
        const salario = $('#salario').val();
        const dpi = $('#dpi').val().trim();

        if (!especialidad) {
            mostrarErrorValidacion('Campo Obligatorio', 'La especialidad es obligatoria para maestros.', 'especialidad');
            return false;
        }
        if (!tituloacademico) {
            mostrarErrorValidacion('Campo Obligatorio', 'El título académico es obligatorio para maestros.', 'tituloacademico');
            return false;
        }
        if (salario === '' || parseFloat(salario) < 0) {
            mostrarErrorValidacion('Campo Obligatorio', 'El salario actual es obligatorio y debe ser un número positivo para maestros.', 'salario');
            return false;
        }
        if (!dpi) {
            mostrarErrorValidacion('Campo Obligatorio', 'El número de DPI es obligatorio para maestros.', 'dpi');
            return false;
        }
    } else if (rol === 'A') {
        const nombreContacto1 = $('#nombre_contacto_1').val().trim();
        const numeroContacto1 = $('#numero_contacto_1').val().trim();

        if (!nombreContacto1) {
            mostrarErrorValidacion('Campo Obligatorio', 'El nombre de contacto 1 es obligatorio para alumnos.', 'nombre_contacto_1');
            return false;
        }
        if (!numeroContacto1) {
            mostrarErrorValidacion('Campo Obligatorio', 'El número de contacto 1 es obligatorio para alumnos.', 'numero_contacto_1');
            return false;
        }
    }

    return true;
}

// --- Main Document Ready Block ---
$(document).ready(function () {
    ACCION_GLOBAL = determinarModoFormulario();
    
    if (ACCION_GLOBAL === 'U') {
        document.getElementById("titulo").textContent = "Modificar Usuario";
        recuperarPersona();
    } else {
        document.getElementById("titulo").textContent = "Agregar Usuario";
        mostrarCamposPorRol(); // Ensure initial state is correct for add mode
    }

    $("#btnGuardar").click(() => {
        if (!validarFormulario()) {
            return;
        }
        
        const datosPersona = recopilarDatosFormulario();
        
        mostrarConfirmacion(
            'Confirmar Guardado',
            '¿Está seguro de que desea guardar los cambios en la información de la persona?',
            '<i class="bi bi-check me-2"></i>Sí, guardar',
            '<i class="bi bi-x me-2"></i>Cancelar',
            '#198754',
            '#6c757d',
            () => ejecutarGuardado(datosPersona)
        );
    });

    function ejecutarGuardado(datosPersona) {
        showLoading();
        
        $.ajax({
            url: apiBaseUrl,
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datosPersona),
            success: function(response) {
                hideLoading();
                if (response.mensaje && response.mensaje.trim() !== "") {
                    mostrarError('Error al Guardar', response.mensaje);
                } else {
                    mostrarExito('Los datos de la persona se han guardado correctamente.');
                    if (ACCION_GLOBAL === 'U') {
                        window.location.href = '/usuarios';
                    } else {
                        document.getElementById('personaForm').reset();
                        mostrarCamposPorRol(); // Reset visibility after form clear
                    }
                }
            },
            error: function(xhr, status, error) {
                hideLoading();
                console.error('Error al guardar persona:', error);
                if (xhr.status === 0) {
                    mostrarErrorConexion();
                } else if (xhr.status >= 500) {
                    mostrarError('Error del Servidor', 'Ocurrió un error interno en el servidor. Por favor, intente nuevamente más tarde.');
                } else {
                    mostrarError('Error Inesperado', 'Ocurrió un error inesperado al guardar la persona. Por favor, intente nuevamente.');
                }
            }
        });
    }

    $("#cancelar").click(() => {
        mostrarConfirmacion(
            '¿Cancelar cambios?',
            '¿Está seguro de que desea cancelar? Los cambios no guardados se perderán.',
            '<i class="bi bi-x-circle me-2"></i>Sí, cancelar',
            '<i class="bi bi-arrow-left me-2"></i>No, continuar',
            '#dc3545',
            '#6c757d',
            () => { window.location.href = '/usuarios'; }
        );
    });
});
</script>

@endsection
