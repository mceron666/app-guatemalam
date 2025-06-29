@extends("layouts.maestro")

@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Estilos personalizados para el header dinámico */
.header-section-dynamic {
    padding: 20px 0;
    margin-bottom: 20px;
    border-radius: 12px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
    text-align: center;
    color: white;
    position: relative;
    overflow: hidden;
}

.header-section-dynamic::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    pointer-events: none;
}

.header-content-dynamic {
    position: relative;
    z-index: 2;
}

.header-title-dynamic {
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.header-subject-dynamic {
    font-size: 36px;
    font-weight: 900;
    margin: 15px 0;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.4);
    letter-spacing: 1px;
}

.header-grade-dynamic {
    font-size: 18px;
    font-weight: 500;
    opacity: 0.95;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.header-activity-dynamic {
    font-size: 20px;
    font-weight: 600;
    margin-top: 10px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
}

.header-icon-dynamic {
    font-size: 24px;
    margin-right: 10px;
    opacity: 0.9;
}

.punteo-input {
    width: 80px;
    text-align: center;
}

.alumno-row:hover {
    background-color: #f8f9fa;
}
</style>

<!-- Header Section Dinámico -->
<div id="headerSectionDynamic" class="header-section-dynamic" style="background-color: #6c757d;">
    <div class="container">
        <div class="header-content-dynamic">
            <div class="header-title-dynamic">
                <i class="fas fa-edit header-icon-dynamic"></i>
                Ingreso de Notas por Actividad
            </div>
            <div id="headerSubjectName" class="header-subject-dynamic">
                Cargando materia...
            </div>
            <div id="headerGradeName" class="header-grade-dynamic">
                Cargando grado...
            </div>
            <div id="headerActivityName" class="header-activity-dynamic">
                Cargando actividad...
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        Lista de Estudiantes
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <div class="card bg-info text-white d-inline-block">
                        <div class="card-body text-center py-2 px-3">
                            <h6 class="mb-0">Total Estudiantes: <span id="totalEstudiantes">0</span></h6>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="tablaAlumnos" class="table table-striped">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th scope="col" width="10%">No.</th>
                            <th scope="col" width="60%">Nombre del Estudiante</th>
                            <th scope="col" width="20%">Punteo</th>
                            <th scope="col" width="10%">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Cargando...</span>
                                </div>
                                <p class="mt-2">Cargando estudiantes...</p>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="row mt-4">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-success btn-lg px-5" id="btnGuardarPunteos">
                        <i class="bi bi-check-circle me-2"></i>Guardar Punteos
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    
const apiBaseUrl = 'http://localhost:3000';

// Obtener parámetros de la URL
function getUrlParameters() {
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Buscar el índice de 'evaluaciones' en la URL
    const evaluacionesIndex = segments.indexOf('evaluaciones');
    
    if (evaluacionesIndex !== -1 && segments.length > evaluacionesIndex + 5) {
        return {
            periodo: parseInt(segments[evaluacionesIndex + 1]),
            grado: parseInt(segments[evaluacionesIndex + 2]),
            materia: parseInt(segments[evaluacionesIndex + 3]),
            bloque: parseInt(segments[evaluacionesIndex + 4]),
            orden: parseInt(segments[evaluacionesIndex + 5])
        };
    }
    
    return { periodo: null, grado: null, materia: null, bloque: null, orden: null };
}

// Variables globales
let urlParams = getUrlParameters();
let alumnosData = [];
let materiaData = null;
let gradoData = null;
let actividadData = null;

// Cargar información de la materia
function cargarInfoMateria() {
    $.ajax({
        url: `${apiBaseUrl}/materias/${urlParams.materia}/id`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.data && response.data.length > 0) {
                const materia = response.data[0];
                materiaData = materia;
                
                // Aplicar color y estilo de texto
                const colorFondo = materia.COLOR_MATERIA || '#6c757d';
                const colorTexto = materia.USA_LETRAS_BLANCAS === 'Y' ? 'white' : 'black';
                
                // Actualizar header completo con el color de la materia
                const headerSection = document.getElementById('headerSectionDynamic');
                headerSection.style.backgroundColor = colorFondo;
                headerSection.style.color = colorTexto;
                
                // Actualizar nombre de la materia en el header
                document.getElementById('headerSubjectName').textContent = materia.NOMBRE_MATERIA;
            } else {
                console.error('No se encontró información de la materia');
                document.getElementById('headerSubjectName').textContent = 'Materia no encontrada';
            }
        },
        error: function(error) {
            console.error('Error al cargar información de la materia:', error);
            document.getElementById('headerSubjectName').textContent = 'Error al cargar materia';
        }
    });
}

// Cargar información del grado
function cargarInfoGrado() {
    $.ajax({
        url: `${apiBaseUrl}/grados/${urlParams.grado}/i`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.data && response.data.length > 0) {
                const grado = response.data[0];
                gradoData = grado;
                document.getElementById('headerGradeName').textContent = grado.NOMBRE_GRADO;
            } else {
                document.getElementById('headerGradeName').textContent = 'Grado no encontrado';
            }
        },
        error: function(error) {
            console.error('Error al cargar información del grado:', error);
            document.getElementById('headerGradeName').textContent = 'Error al cargar grado';
        }
    });
}

// Cargar información de la actividad
function cargarInfoActividad() {
    const datos = {
        ID_GRADO: urlParams.grado,
        ID_MATERIA: urlParams.materia,
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_BLOQUE_ESCOLAR: urlParams.bloque
    };
    
    $.ajax({
        url: `${apiBaseUrl}/evaluaciones/lista`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            if (response.data && response.data.length > 0) {
                const actividad = response.data.find(eval => eval.ORDEN_EVALUACION == urlParams.orden);
                if (actividad) {
                    actividadData = actividad;
                    document.getElementById('headerActivityName').textContent = 
                        `Actividad ${actividad.ORDEN_EVALUACION}: ${actividad.DESCRIPCION_EVALUACION} (${actividad.PUNTEO_ESTIPULADO} pts)`;
                } else {
                    document.getElementById('headerActivityName').textContent = 'Actividad no encontrada';
                }
            }
        },
        error: function(error) {
            console.error('Error al cargar información de la actividad:', error);
            document.getElementById('headerActivityName').textContent = 'Error al cargar actividad';
        }
    });
}

// Cargar lista de alumnos
function cargarAlumnos() {
    const datos = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_MATERIA: urlParams.materia,
        ID_GRADO: urlParams.grado,
        ID_BLOQUE_ESCOLAR: urlParams.bloque,
        ORDEN_EVALUACION: urlParams.orden
    };
    
    $.ajax({
        url: `${apiBaseUrl}/notas/evaluacion`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            if (response.data && response.data.length > 0) {
                alumnosData = response.data;
                mostrarAlumnos();
                document.getElementById('totalEstudiantes').textContent = response.total || response.data.length;
            } else {
                const tbody = $('#tablaAlumnos tbody');
                tbody.html('<tr><td colspan="4" class="text-center">No se encontraron estudiantes</td></tr>');
                document.getElementById('totalEstudiantes').textContent = '0';
            }
        },
        error: function(error) {
            console.error('Error al cargar alumnos:', error);
            const tbody = $('#tablaAlumnos tbody');
            tbody.html('<tr><td colspan="4" class="text-center text-danger">Error al cargar estudiantes</td></tr>');
        }
    });
}

// Mostrar alumnos en la tabla
function mostrarAlumnos() {
    const tbody = $('#tablaAlumnos tbody');
    tbody.empty();
    
    alumnosData.forEach((alumno, index) => {
        const fila = `
            <tr class="alumno-row">
                <td><span class="badge bg-secondary">${alumno.NUMERO_FILA}</span></td>
                <td class="text-start">
                    <div class="d-flex align-items-center">
                        <div class="avatar-circle bg-primary text-white me-2" style="width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                            ${alumno.NOMBRE_ALUMNO.charAt(0).toUpperCase()}
                        </div>
                        <div>
                            <div class="fw-semibold">${alumno.NOMBRE_ALUMNO}</div>
                            <small class="text-muted">@${alumno.PERFIL_PERSONA}</small>
                        </div>
                    </div>
                </td>
                <td>
                    <input 
                        type="number" 
                        class="form-control punteo-input" 
                        value="${alumno.PUNTEO_ALUMNO}" 
                        min="0" 
                        max="${actividadData ? actividadData.PUNTEO_ESTIPULADO : 100}"
                        data-alumno-id="${alumno.ID_ALUMNO_GRADO}"
                        data-numero-fila="${alumno.NUMERO_FILA}"
                        onchange="validarPunteo(this)"
                    >
                </td>
                <td>
                    <span class="badge ${alumno.PUNTEO_ALUMNO > 0 ? 'bg-success' : 'bg-warning'}">
                        ${alumno.PUNTEO_ALUMNO > 0 ? 'Con Nota' : 'Sin Nota'}
                    </span>
                </td>
            </tr>
        `;
        tbody.append(fila);
    });
}

// Validar punteo ingresado
function validarPunteo(input) {
    const maxPunteo = actividadData ? actividadData.PUNTEO_ESTIPULADO : 100;
    const valor = parseFloat(input.value);
    
    if (valor < 0) {
        input.value = 0;
        Swal.fire({
            icon: 'warning',
            title: 'Punteo inválido',
            text: 'El punteo no puede ser menor a 0',
            timer: 2000,
            showConfirmButton: false
        });
    } else if (valor > maxPunteo) {
        input.value = maxPunteo;
        Swal.fire({
            icon: 'warning',
            title: 'Punteo excedido',
            text: `El punteo máximo para esta actividad es ${maxPunteo}`,
            timer: 2000,
            showConfirmButton: false
        });
    }
    
    // Actualizar estado visual
    const row = $(input).closest('tr');
    const badge = row.find('.badge:last');
    if (parseFloat(input.value) > 0) {
        badge.removeClass('bg-warning').addClass('bg-success').text('Con Nota');
    } else {
        badge.removeClass('bg-success').addClass('bg-warning').text('Sin Nota');
    }
}

// Guardar punteos
function guardarPunteos() {
    // Recopilar datos de los inputs
    const notas = [];
    $('.punteo-input').each(function() {
        const input = $(this);
        notas.push({
            NUMERO_FILA: input.data('numero-fila').toString(),
            ID_ALUMNO: input.data('alumno-id'),
            PUNTEO_ALUMNO: parseFloat(input.val()) || 0
        });
    });
    
    const datos = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_MATERIA: urlParams.materia,
        ID_GRADO: urlParams.grado,
        ID_BLOQUE_ESCOLAR: urlParams.bloque,
        ORDEN_EVALUACION: urlParams.orden,
        notas: notas
    };
    
    // Mostrar loading
    Swal.fire({
        title: 'Guardando...',
        text: 'Por favor espere mientras se guardan las notas',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });
    
    $.ajax({
        url: `${apiBaseUrl}/notas`,
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
                    text: 'Las notas se han guardado correctamente',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    // Recargar datos para mostrar cambios
                    cargarAlumnos();
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
            console.error('Error al guardar punteos:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error de conexión',
                text: 'No se pudo conectar con el servidor. Por favor intente nuevamente.',
                confirmButtonText: 'Entendido'
            });
        }
    });
}
$(document).ready(function() {
    // Verificar que tenemos parámetros válidos
    if (!urlParams.periodo || !urlParams.grado || !urlParams.materia || !urlParams.bloque || !urlParams.orden) {
        Swal.fire({
            icon: 'error',
            title: 'URL no válida',
            text: 'Debe acceder desde /evaluaciones/{periodo}/{grado}/{materia}/{bloque}/{orden}',
            confirmButtonText: 'Entendido'
        });
        return;
    }
    
    // Cargar información inicial
    cargarInfoMateria();
    cargarInfoGrado();
    cargarInfoActividad();
    cargarAlumnos();
    
    // Evento del botón guardar
    $('#btnGuardarPunteos').click(function() {
        Swal.fire({
            title: '¿Confirmar guardado?',
            text: 'Se guardarán todas las notas ingresadas',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                guardarPunteos();
            }
        });
    });
});
</script>
@endsection