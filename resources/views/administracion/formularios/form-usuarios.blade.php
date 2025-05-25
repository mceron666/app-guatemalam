@extends("layouts.header")

@section("contenido")
<link href="/css/form.css" rel="stylesheet">
<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-success text-white py-3">
            <h4 class="mb-0" id="titulo"><i class="bi bi-person-plus-fill me-2"></i>Agregar Persona</h4>
        </div>
        <div class="card-body p-4 bg-light">
            <!-- Área para mensajes de alerta -->
            <div id="errorMessageContainer" class="alert alert-danger d-none">
                <div class="d-flex align-items-center">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <span id="errorMessage">Mensaje de error aquí</span>
                </div>
            </div>

            <form id="personaForm" class="needs-validation">
                <!-- Información Personal -->
                <div class="card mb-4 border-0 shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0 text-success"><i class="bi bi-person me-2"></i>Información Personal</h5>
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
                            <h5 class="mb-0 text-success"><i class="bi bi-mortarboard me-2"></i>Información de Maestro</h5>
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
                            <h5 class="mb-0 text-success"><i class="bi bi-backpack me-2"></i>Información de Alumno</h5>
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

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};        
let ACCION_GLOBAL;
function mostrarCamposPorRol() {
    const rol = document.getElementById('rol').value;
    const camposMaestro = document.getElementById('camposMaestro');
    const camposAlumno = document.getElementById('camposAlumno');
    camposMaestro.style.display = 'none';
    camposAlumno.style.display = 'none';
    if (rol === 'M' || rol === 'P') {
        camposMaestro.style.display = 'block';
    } else if (rol === 'A') {
        camposAlumno.style.display = 'block';
        }
}
mostrarCamposPorRol();
function recopilarDatosFormulario() {
    const datosPersona = {
        ID_PERSONA_INGRESO: ID_PERSONA,
        ACCION: ACCION_GLOBAL,
        NOMBRES_PERSONA: document.getElementById('nombres').value,
        APELLIDOS_PERSONA: document.getElementById('apellidos').value,
        CORREO_PERSONA: document.getElementById('correo').value,
        PERFIL_PERSONA: document.getElementById('perfil').value,
        NUMERO_PERSONA: document.getElementById('numero').value,
        ROL_PERSONA: document.getElementById('rol').value,
        SEXO_PERSONA: document.querySelector('input[name="SEXO_PERSONA"]:checked')?.value || 'X',
        ESPECIALIDAD: '',
        TITULO_ACADEMICO: '',
        SALARIO_ACTUAL: 0,
        NUMERO_DPI: '',
        NOMBRE_CONTACTO_1: '',
        NUMERO_CONTACTO_1: '',
        NOMBRE_CONTACTO_2: '',
        NUMERO_CONTACTO_2: ''
    };
    const rol = document.getElementById('rol').value;
    if (rol === 'M' || rol === 'P') {
        datosPersona.ESPECIALIDAD = document.getElementById('especialidad').value;
        datosPersona.TITULO_ACADEMICO = document.getElementById('tituloacademico').value;
        datosPersona.SALARIO_ACTUAL = parseFloat(document.getElementById('salario').value) || 0;
        datosPersona.NUMERO_DPI = document.getElementById('dpi').value;
    }
    if (rol === 'A') {
        datosPersona.NOMBRE_CONTACTO_1 = document.getElementById('nombre_contacto_1').value;
        datosPersona.NUMERO_CONTACTO_1 = document.getElementById('numero_contacto_1').value;
        datosPersona.NOMBRE_CONTACTO_2 = document.getElementById('nombre_contacto_2').value;
        datosPersona.NUMERO_CONTACTO_2 = document.getElementById('numero_contacto_2').value;
    }
    
    return datosPersona;
}
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
    const esModoEdicion = rutaActual.includes('modificar-usuario');
    
    const accion = esModoEdicion ? 'U' : 'I';
    if (esModoEdicion) {
        console.log('Modo edición detectado. Protegiendo campos...');
        
        document.getElementById('rol').disabled = true;
        document.getElementById('perfil').readOnly = true;
        document.getElementById('sexoM').disabled = true;
        document.getElementById('sexoF').disabled = true;
        
        document.getElementById('rol').addEventListener('change', protegerCamposDPI);
        protegerCamposDPI();
    }
    
    return accion;
}

/**
 * Función auxiliar para proteger el campo DPI si el rol es maestro
 */
function protegerCamposDPI() {
    const rol = document.getElementById('rol').value;
    
    // Si el rol es maestro (M) o maestro administrador (P) y estamos en modo edición
    if ((rol === 'M' || rol === 'P') && ACCION_GLOBAL === 'U') {
        const dpiField = document.getElementById('dpi');
        if (dpiField) {
            dpiField.readOnly = true;
        }
    }
}
function recuperarPersona() {
    // Obtener el identificador de la URL
    const urlCompleta = window.location.pathname;
    const partes = urlCompleta.split('/');
    const identificador = partes[partes.length - 1]; // Obtiene el último segmento de la URL
    
    // Verificar si se obtuvo un identificador
    if (!identificador) {
        console.error('No se pudo identificar el usuario en la URL:', urlCompleta);
        return;
    }
    
    console.log('Identificador obtenido:', identificador);
    
    // Realizar la petición a la API
    fetch(`http://localhost:3000/personas/${identificador}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error al obtener los datos de la persona');
            }
            return response.json();
        })
        .then(responseData => {
            if (!responseData.data || responseData.data.length === 0) {
                console.error('No se encontraron datos para esta persona');
                return;
            }
            
            // Obtener los datos de la persona (primer elemento del array data)
            const persona = responseData.data[0];
            console.log('Datos obtenidos:', persona);
            
            // Llenar los campos del formulario con los datos obtenidos
            document.getElementById('nombres').value = persona.NOMBRES_PERSONA || '';
            document.getElementById('apellidos').value = persona.APELLIDOS_PERSONA || '';
            document.getElementById('perfil').value = persona.PERFIL_PERSONA || '';
            document.getElementById('correo').value = persona.CORREO_PERSONA || '';
            document.getElementById('numero').value = persona.NUMERO_PERSONA || '';
            
            // Establecer el rol y mostrar los campos correspondientes
            const selectRol = document.getElementById('rol');
            selectRol.value = persona.ROL_PERSONA || '';
            mostrarCamposPorRol();
            
            // Establecer el sexo
            if (persona.SEXO_PERSONA === 'M') {
                document.getElementById('sexoM').checked = true;
            } else if (persona.SEXO_PERSONA === 'F') {
                document.getElementById('sexoF').checked = true;
            }
            
            // Si es maestro (M o P), llenar los campos de maestro
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
        })
        .catch(error => {
            console.error('Error:', error);
            // Mostrar el error en la consola para depuración
            console.error('Error al recuperar los datos:', error.message);
            
            // Si tienes la función showError funcionando, puedes usarla también
            if (typeof showError === 'function') {
                showError('Error al recuperar los datos: ' + error.message);
            }
        });
}
$(document).ready(function () {
    ACCION_GLOBAL = determinarModoFormulario();
    if (ACCION_GLOBAL === 'U')
    {
        recuperarPersona();   
        document.getElementById("titulo").textContent = "Modificar usuario";
    } else {
        document.getElementById("titulo").textContent = "Agregar usuario";
    }
    $("#btnGuardar").click(() => {
        const datosPersona = recopilarDatosFormulario();
        fetch('http://localhost:3000/personas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(datosPersona)
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
                    window.location.href = '/usuarios';    
                } else {
                    document.getElementById('personaForm').reset();
                    hideError();
                }
                mostrarCamposPorRol(); // Actualizar visibilidad de campos
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Error de conexión. Intente nuevamente.');
        });
    })    
    $("#cancelar").click(() => {    
        window.location.href = '/usuarios';
    });    
});    
</script>
@endsection