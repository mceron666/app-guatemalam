@extends("layouts.maestro")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">

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

.header-icon-dynamic {
    font-size: 24px;
    margin-right: 10px;
    opacity: 0.9;
}
</style>

<!-- Header Section Dinámico -->
<div id="headerSectionDynamic" class="header-section-dynamic" style="background-color: #6c757d;">
    <div class="container">
        <div class="header-content-dynamic">
            <div id="headerSubjectName" class="header-subject-dynamic">
                Cargando materia...
            </div>
            <div id="headerGradeName" class="header-grade-dynamic">
                Cargando grado...
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <!-- Selector de Bloque -->
                <div class="col-md-4 col-lg-4">
                    <label for="selectorBloque" class="form-label fw-semibold">
                        <i class="bi bi-calendar3 text-success"></i>
                        Filtrar por Bloque
                    </label>
                    <select id="selectorBloque" class="form-select">
                        <option value="">Cargando bloques...</option>
                    </select>
                </div>
                
                <!-- Botón de agregar -->
                <div class="col-md-4 col-lg-4 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#evaluacionModal">
                        <i class="bi bi-plus-circle me-1"></i>Agregar Evaluación
                    </button>
                </div>
                
                <!-- Estadísticas -->
                <div class="col-md-4 col-lg-4">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center py-2">
                            <h4 class="mb-0" id="totalPunteo">0</h4>
                            <small>Punteo Total</small>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="table-responsive">
                <table id="tablaEvaluaciones" class="table">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Orden</th>
                            <th scope="col">Descripción</th>                            
                            <th scope="col">Punteo</th>
                            <th scope="col">Bloque</th>
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

<!-- Modal para Evaluaciones -->
<div class="modal fade custom-modal" id="evaluacionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header text-white" style="background-color: #198754;">
        <div class="d-flex align-items-center">
          <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
          <h4 class="modal-title" id="titulo">Agregar Evaluación</h4>
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
        <form id="evaluacionForm">
          <input type="hidden" id="evaluacionId" name="ID_EVALUACION">
          <input type="hidden" id="periodoId" name="ID_PERIODO_ESCOLAR">
          <input type="hidden" id="gradoId" name="ID_GRADO">
          <input type="hidden" id="materiaId" name="ID_MATERIA">
          
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Información de Contexto</h5>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Período</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                      <input type="text" class="form-control" id="periodoSeleccionado" readonly>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Grado</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                      <input type="text" class="form-control" id="gradoSeleccionado" readonly>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Materia</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-book"></i></span>
                      <input type="text" class="form-control" id="materiaSeleccionada" readonly>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Bloque Seleccionado</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-calendar3"></i></span>
                      <input type="text" class="form-control" id="bloqueSeleccionadoTexto" readonly>
                    </div>
                    <small class="text-muted">El bloque se selecciona desde la lista principal</small>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Datos de la Evaluación</h5>
                  <div class="mb-3">
                    <label for="ordenEvaluacion" class="form-label fw-semibold">Orden</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-sort-numeric-up"></i></span>
                      <input type="number" class="form-control" id="ordenEvaluacion" name="ORDEN_EVALUACION" min="1" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="descripcionEvaluacion" class="form-label fw-semibold">Descripción</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-edit"></i></span>
                      <input type="text" class="form-control" id="descripcionEvaluacion" name="DESCRIPCION_EVALUACION" required>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="punteoEstipulado" class="form-label fw-semibold">Punteo</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light"><i class="fas fa-star"></i></span>
                      <input type="number" class="form-control" id="punteoEstipulado" name="PUNTEO_ESTIPULADO" min="1" required>
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
          <i class="bi bi-check-circle me-2"></i>Guardar
        </button>
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
    
    if (evaluacionesIndex !== -1 && segments.length > evaluacionesIndex + 3) {
        return {
            periodo: parseInt(segments[evaluacionesIndex + 1]),
            grado: parseInt(segments[evaluacionesIndex + 2]),
            materia: parseInt(segments[evaluacionesIndex + 3])
        };
    }
    
    return { periodo: null, grado: null, materia: null };
}

// Variables globales
let urlParams = getUrlParameters();
let currentPage = 1;
let totalPages = 1;
let bloqueSeleccionado = null;
let bloquesData = [];
let materiaData = null;

// Cargar información específica de la materia y actualizar header
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
                
                // Actualizar campo en modal
                document.getElementById('materiaSeleccionada').value = materia.NOMBRE_MATERIA;
                document.getElementById('materiaId').value = materia.ID_MATERIA;
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

// Cargar información del período, grado y materia
function cargarInfoCompleta() {
    if (!urlParams.periodo || !urlParams.grado || !urlParams.materia) {
        console.error('Parámetros de URL no válidos');
        return;
    }
    
    // Cargar información del período (solo para el modal)
    axios.get(`${apiBaseUrl}/periodos/seleccion`)
        .then(response => {
            const periodos = response.data;
            const periodo = periodos.find(p => p.ID_PERIODO_ESCOLAR == urlParams.periodo);
            if (periodo) {
                document.getElementById('periodoSeleccionado').value = periodo.DESCRIPCION_PERIODO;
                document.getElementById('periodoId').value = periodo.ID_PERIODO_ESCOLAR;
            }
        })
        .catch(error => {
            console.error('Error al cargar información del período:', error);
        });
    
    // Cargar información del grado
    $.ajax({
        url: `${apiBaseUrl}/grados/${urlParams.grado}/i`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const grado = response.data[0];
            if (grado) {
                // Solo mostrar el nombre del grado en el header
                document.getElementById('headerGradeName').textContent = grado.NOMBRE_GRADO;
                document.getElementById('gradoSeleccionado').value = grado.NOMBRE_GRADO;
                document.getElementById('gradoId').value = grado.CODIGO_GRADO;
            }
        },
        error: function(error) {
            console.error('Error al cargar información del grado:', error);
        }
    });
    
    // Cargar información de la materia
    cargarInfoMateria();
}

// Actualizar información del bloque seleccionado en el modal
function actualizarBloqueEnModal() {
    if (bloqueSeleccionado && bloquesData.length > 0) {
        const bloque = bloquesData.find(b => b.ID_BLOQUE_ESCOLAR == bloqueSeleccionado);
        if (bloque) {
            document.getElementById('bloqueSeleccionadoTexto').value = bloque.NOMBRE_BLOQUE;
        }
    } else {
        document.getElementById('bloqueSeleccionadoTexto').value = 'Todos los bloques';
    }
}

// Cargar bloques
function cargarBloques() {
    if (!urlParams.periodo) {
        return;
    }

    const datos = {
        ID_PERIODO_ESCOLAR: parseInt(urlParams.periodo)
    };

    $.ajax({
        url: `${apiBaseUrl}/bloques`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            if (response && response.bloques && response.bloques.length > 0) {
                bloquesData = response.bloques;
                
                // Llenar selector principal
                const selectorBloque = $('#selectorBloque');
                selectorBloque.empty();
                selectorBloque.append('<option value="">Todos los bloques</option>');
                
                response.bloques.forEach((bloque) => {
                    const option = `<option value="${bloque.ID_BLOQUE_ESCOLAR}">${bloque.NOMBRE_BLOQUE}</option>`;
                    selectorBloque.append(option);
                });
                
                // Seleccionar el primer bloque por defecto
                bloqueSeleccionado = response.bloques[0].ID_BLOQUE_ESCOLAR;
                selectorBloque.val(bloqueSeleccionado);
                actualizarBloqueEnModal();
                cargarEvaluaciones();
            }
        },
        error: function(error) {
            console.error('Error al cargar bloques:', error);
        }
    });
}

// Cargar evaluaciones
function cargarEvaluaciones(page = 1) {
    if (!urlParams.periodo || !urlParams.grado || !urlParams.materia) {
        $('#tablaEvaluaciones tbody').html('<tr><td colspan="5" class="text-center">Parámetros de URL no válidos</td></tr>');
        return;
    }
    
    const datos = {
        ID_GRADO: urlParams.grado,
        ID_MATERIA: urlParams.materia,
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_BLOQUE_ESCOLAR: bloqueSeleccionado || null
    };
    
    $.ajax({
        url: `${apiBaseUrl}/evaluaciones/lista`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(datos),
        success: function(response) {
            const data = response.data;
            const tbody = $('#tablaEvaluaciones tbody');
            tbody.empty();
            
            if (data.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">No se encontraron evaluaciones</td></tr>');
                $('#totalPunteo').text('0');
            } else {
                let totalPunteo = 0;
                
                data.forEach(evaluacion => {
                    totalPunteo += evaluacion.PUNTEO_ESTIPULADO;
                    
                    const bloque = bloquesData.find(b => b.ID_BLOQUE_ESCOLAR == evaluacion.ID_BLOQUE_ESCOLAR);
                    const nombreBloque = bloque ? bloque.NOMBRE_BLOQUE : 'N/A';
                    
const fila = `
<tr>
    <td><span class="badge bg-primary">${evaluacion.ORDEN_EVALUACION}</span></td>
    <td>${evaluacion.DESCRIPCION_EVALUACION}</td>
    <td><span class="badge bg-success">${evaluacion.PUNTEO_ESTIPULADO} pts</span></td>
    <td>${nombreBloque}</td>
    <td>
        <div class="d-flex flex-wrap justify-content-center gap-2">
            <a 
                href="/maestro/evaluaciones/${urlParams.periodo}/${urlParams.grado}/${urlParams.materia}/${bloqueSeleccionado}/${evaluacion.ORDEN_EVALUACION}" 
                class="btn btn-secondary btn-sm">
                <i class="bi bi-pencil"></i> Calificar
            </a>
            <button 
                class="btn btn-warning btn-sm btn-editar" 
                data-bs-toggle="modal" 
                data-bs-target="#evaluacionModal"
                data-orden="${evaluacion.ORDEN_EVALUACION}"
                data-descripcion="${evaluacion.DESCRIPCION_EVALUACION}"
                data-punteo="${evaluacion.PUNTEO_ESTIPULADO}"
                data-bloque="${evaluacion.ID_BLOQUE_ESCOLAR}">
                <i class="bi bi-pencil-square"></i> Modificar
            </button>
            <button 
                data-bs-toggle="modal" 
                data-bs-target="#deleteModal" 
                class="btn btn-danger btn-sm btn-eliminar" 
                data-orden="${evaluacion.ORDEN_EVALUACION}" 
                data-descripcion="${evaluacion.DESCRIPCION_EVALUACION}">
                <i class="bi bi-trash"></i> Eliminar
            </button>
        </div>
    </td>
</tr>
`;
                    tbody.append(fila);
                });
                
                $('#totalPunteo').text(totalPunteo);
            }
        },
        error: function(error) {
            console.error('Error al cargar las evaluaciones:', error);
            $('#tablaEvaluaciones tbody').html('<tr><td colspan="5" class="text-center">Error al cargar datos</td></tr>');
        }
    });
}

// Mostrar/ocultar mensajes de error
function showError(message) {
    const errorContainer = document.getElementById("errorMessageContainer");
    const errorMessageElement = document.getElementById("errorMessage");
    errorMessageElement.textContent = message;
    errorContainer.classList.remove("d-none");
}

function hideError() {
    const errorContainer = document.getElementById('errorMessageContainer');
    errorContainer.classList.add('d-none');
}

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    // Verificar que tenemos parámetros válidos
    if (!urlParams.periodo || !urlParams.grado || !urlParams.materia) {
        alert('URL no válida. Debe acceder desde /evaluaciones/{periodo}/{grado}/{materia}');
        return;
    }
    
    // Cargar información inicial
    cargarInfoCompleta();
    cargarBloques();
    
    // Selector de bloque
    $('#selectorBloque').on('change', function() {
        bloqueSeleccionado = $(this).val() || null;
        actualizarBloqueEnModal();
        cargarEvaluaciones();
    });
    
    // Botón agregar
    $("#agregar").click(function() {
        // Validar que hay un bloque seleccionado
        if (!bloqueSeleccionado) {
            alert('Por favor selecciona un bloque antes de agregar una evaluación');
            return;
        }
        
        hideError();
        $("#ordenEvaluacion").val("");
        $("#descripcionEvaluacion").val("");
        $("#punteoEstipulado").val("");
        actualizarBloqueEnModal();
        $("#titulo").text("Agregar Evaluación");
    });
    
    // Botón editar
    $(document).on("click", ".btn-editar", function() {
        hideError();
        const orden = $(this).data("orden");
        const descripcion = $(this).data("descripcion");
        const punteo = $(this).data("punteo");
        const bloque = $(this).data("bloque");
        
        $("#ordenEvaluacion").val(orden);
        $("#descripcionEvaluacion").val(descripcion);
        $("#punteoEstipulado").val(punteo);
        
        // Actualizar el bloque seleccionado para la edición
        bloqueSeleccionado = bloque;
        $('#selectorBloque').val(bloque);
        actualizarBloqueEnModal();
        
        $("#titulo").text("Modificar Evaluación");
    });
    
    // Botón eliminar
    $(document).on("click", ".btn-eliminar", function() {
        const orden = $(this).data("orden");
        const descripcion = $(this).data("descripcion");
        $("#CodigoEliminar").text(orden);
        $("#DescripcionEliminar").text(descripcion);
        $("#ideliminacion").val(orden);
    });

    // Botón confirmar eliminación
    $("#btnConfirmDelete").click(function() {
        const orden = parseInt($("#ideliminacion").val());
        const datos = {
            ORDEN_EVALUACION: orden,
            DESCRIPCION_EVALUACION: "",
            PUNTEO_ESTIPULADO: 0,
            ID_PERSONA_INGRESO: ID_PERSONA,
            ID_MATERIA: urlParams.materia,
            ID_GRADO: urlParams.grado,
            ID_PERIODO_ESCOLAR: urlParams.periodo,
            ID_BLOQUE_ESCOLAR: bloqueSeleccionado,
            ACCION: 'D'
        }; 
        
        $.ajax({
            url: `${apiBaseUrl}/evaluaciones`,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            success: function(response) {
                $("#deleteModal").modal("hide");
                cargarEvaluaciones();
            },
            error: function(err) {
                console.error(err);
                alert("Ocurrió un error al eliminar la evaluación.");
            }
        });
    });
    
    // Botón guardar
    $("#btnGuardar").click(function() {
        // Validar que hay un bloque seleccionado
        if (!bloqueSeleccionado) {
            showError('Debe seleccionar un bloque desde la lista principal');
            return;
        }
        
        const titulo = $("#titulo").text().trim();
        const accion = titulo === "Agregar Evaluación" ? "I" : "U";
        
        const datos = {
            ORDEN_EVALUACION: parseInt($("#ordenEvaluacion").val()),
            DESCRIPCION_EVALUACION: $("#descripcionEvaluacion").val(),
            PUNTEO_ESTIPULADO: parseInt($("#punteoEstipulado").val()),
            ID_PERSONA_INGRESO: ID_PERSONA,
            ID_MATERIA: urlParams.materia,
            ID_GRADO: urlParams.grado,
            ID_PERIODO_ESCOLAR: urlParams.periodo,
            ID_BLOQUE_ESCOLAR: bloqueSeleccionado, // Usar el bloque seleccionado de la lista
            ACCION: accion
        }; 
        
        $.ajax({
            url: `${apiBaseUrl}/evaluaciones`,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            success: function(response) {
                if (response.mensaje === "" || !response.mensaje) {
                    $("#evaluacionModal").modal("hide");
                    cargarEvaluaciones();
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