@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">
<!-- <div id="header-periodos" class="mb-4" style="background-color: #2e7d32; color: white; padding: 30px; border-radius: 12px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); text-align: center;">
    <div style="font-size: 36px; font-weight: bold;">
        <i class="fas fa-book"></i> Asignación de Materias
    </div>

</div> -->
<div class="header-section">
    <div class="header-title">
        <i class="fas fa-book"></i>
        <span>Administración grados</span>  
    <div class="font-size: 20px; margin-top: 10px;">
        Período: <span id="header-periodo-codigo" style="font-weight: 500;">Cargando...</span> |
        Grado: <span id="header-grado-nombre" style="font-weight: 500;">Cargando...</span>
    </div>                  
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <!-- Botón de agregar -->
                <div class="col-md-4 col-lg-4 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#asignacionModal">
                        <i class="bi bi-plus-circle me-1"></i>Asignar Materia
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaAsignaciones" class="table">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col" >Materia</th>
                            <th scope="col" >Nombre materia</th>                            
                            <th scope="col" >Maestro</th>
                            <th scope="col" >Fecha Asignación</th>
                            <th scope="col" >Acciones</th>
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

<div class="modal fade custom-modal" id="asignacionModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header text-white" style="background-color: #198754;">
        <div class="d-flex align-items-center">
          <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
          <h4 class="modal-title" id="titulo">Asignar Materia a Grado</h4>
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
        <form id="asignacionForm">
          <input type="hidden" id="asignacionId" name="ID_MATERIA_GRADO">
          <input type="hidden" id="periodoId" name="ID_PERIODO_ESCOLAR">
          <input type="hidden" id="gradoId" name="ID_GRADO">
          
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Información del Grado</h5>
                  <div class="mb-4">
                    <label class="form-label fw-semibold">Período Escolar</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="fas fa-calendar-alt"></i></span>
                      <input type="text" class="form-control" id="periodoSeleccionado" readonly>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label class="form-label fw-semibold">Grado</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                      <input type="text" class="form-control" id="gradoSeleccionado" readonly>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Asignación</h5>
                  <div class="mb-4">
                    <label for="selectMateria" class="form-label fw-semibold">Materia</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="fas fa-book"></i></span>
                      <select class="form-select" id="selectMateria" name="ID_MATERIA">
                        <option value="" selected disabled>Seleccione una materia</option>
                        <!-- Options will be populated dynamically -->
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="selectMaestro" class="form-label fw-semibold">Maestro</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="fas fa-chalkboard-teacher"></i></span>
                      <select class="form-select" id="selectMaestro" name="ID_MAESTRO">
                        <option value="" selected disabled>Seleccione un maestro</option>
                        <!-- Options will be populated dynamically -->
                      </select>
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
const apiBaseUrl = 'http://localhost:3000/materias-grado';

// Obtener parámetros de la URL
function getUrlParameters() {
    const path = window.location.pathname;
    const segments = path.split('/');
    
    // Buscar el índice de 'materias' en la URL
    const materiasIndex = segments.indexOf('materias');
    
    if (materiasIndex !== -1 && segments.length > materiasIndex + 2) {
        return {
            periodo: parseInt(segments[materiasIndex + 1]),
            grado: parseInt(segments[materiasIndex + 2])
        };
    }
    
    return { periodo: null, grado: null };
}

// Variables globales para los parámetros de la URL
let urlParams = getUrlParameters();
let currentPage = 1;
let totalPages = 1;
let currentFilters = {};

// Cargar información del período y grado
function cargarInfoPeriodoGrado() {
    if (!urlParams.periodo || !urlParams.grado) {
        console.error('Parámetros de URL no válidos');
        return;
    }
    
    // Cargar información del período
    axios.get('http://localhost:3000/periodos/seleccion')
        .then(response => {
            const periodos = response.data;
            const periodo = periodos.find(p => p.ID_PERIODO_ESCOLAR == urlParams.periodo);
            if (periodo) {
                document.getElementById('header-periodo-codigo').textContent = periodo.CODIGO_PERIODO;
                document.getElementById('periodoSeleccionado').value = periodo.DESCRIPCION_PERIODO;
                document.getElementById('periodoId').value = periodo.ID_PERIODO_ESCOLAR;
            }
        })
        .catch(error => {
            console.error('Error al cargar información del período:', error);
        });
    
    // Cargar información del grado
    const gradoId = urlParams.grado; // Asegúrate de que este valor tenga el ID del grado
$.ajax({
    url: `http://localhost:3000/grados/${gradoId}/i`,
    type: 'GET',
    dataType: 'json',
    success: function(response) {
        const grado = response.data[0]; // Se accede al primer elemento del array
        if (grado) {
            document.getElementById('header-grado-nombre').textContent = grado.NOMBRE_GRADO;
            document.getElementById('gradoSeleccionado').value = grado.NOMBRE_GRADO;
            document.getElementById('gradoId').value = grado.CODIGO_GRADO;
        }
    },
    error: function(error) {
        console.error('Error al cargar información del grado:', error);
    }
});


}

// Cargar asignaciones de materias a grados
function cargarAsignaciones(page = 1) {
    if (!urlParams.periodo || !urlParams.grado) {
        $('#tablaAsignaciones tbody').html('<tr><td colspan="4" class="text-center">Parámetros de URL no válidos</td></tr>');
        return;
    }
    
    // Preparar los filtros con los parámetros de la URL
    const filtros = {
        ID_PERIODO_ESCOLAR: urlParams.periodo,
        ID_GRADO: urlParams.grado,
        ...currentFilters
    };
    
    $.ajax({
        url: `${apiBaseUrl}/filtrar?page=${page}&limit=10`,
        type: 'POST',
        contentType: 'application/json',
        data: JSON.stringify(filtros),
        success: function(response) {
            const data = response.data;
            const pagination = response.pagination;
            currentPage = pagination.currentPage;
            totalPages = pagination.totalPages;
            
            const tbody = $('#tablaAsignaciones tbody');
            tbody.empty();
            
            if (data.length === 0) {
                tbody.append('<tr><td colspan="5" class="text-center">No se encontraron asignaciones para este grado</td></tr>');
            } else {
                data.forEach(asignacion => {
                    const fila = `
                        <tr>
                            <td>${asignacion.CODIGO_MATERIA}</td>                        
                            <td>${asignacion.NOMBRE_MATERIA}</td>
                            <td>${asignacion.NOMBRE_MAESTRO}</td>
                            <td>${formatDate(asignacion.FECHA_INGRESA_REGISTRO)}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button 
                                        class="btn btn-warning btn-sm me-2 btn-editar" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#asignacionModal"
                                        data-id="${asignacion.ID_MATERIA_GRADO}"
                                        data-materia="${asignacion.ID_MATERIA}"
                                        data-maestro="${asignacion.ID_MAESTRO}">
                                        <i class="bi bi-pencil-square"></i> Modificar
                                    </button>
                                    <button data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            class="btn btn-danger btn-sm btn-eliminar" 
                                            data-id="${asignacion.CODIGO_MATERIA}" 
                                            data-nombre="${asignacion.NOMBRE_MATERIA}"
                                            data-idmateria="${asignacion.ID_MATERIA}">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </div>
                            </td>
                        </tr>
                    `;
                    tbody.append(fila);
                });
            }
            actualizarPaginacion();
        },
        error: function(error) {
            console.error('Error al cargar las asignaciones:', error);
            $('#tablaAsignaciones tbody').html('<tr><td colspan="4" class="text-center">Error al cargar datos</td></tr>');
        }
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

// Cargar materias para el selector
function cargarMaterias() {
    $.ajax({
        url: 'http://localhost:3000/materias',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            populateMateriasDropdown(response.data);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar las materias:', error);
        }
    });
}

// Función para llenar el dropdown de materias
function populateMateriasDropdown(materias) {
    const selectMateria = $('#selectMateria');
    
    // Limpiar opciones existentes excepto la primera
    selectMateria.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(materias, function(index, materia) {
        selectMateria.append($('<option>', {
            value: materia.ID_MATERIA,
            text: materia.NOMBRE_MATERIA
        }));
    });
}

// Cargar maestros para el selector
function cargarMaestros() {
    $.ajax({
        url: 'http://localhost:3000/personas/maestros',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            populateMaestrosDropdown(response.data);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los maestros:', error);
        }
    });
}

// Función para llenar el dropdown de maestros
function populateMaestrosDropdown(maestros) {
    const selectMaestro = $('#selectMaestro');
    
    // Limpiar opciones existentes excepto la primera
    selectMaestro.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(maestros, function(index, maestro) {
        selectMaestro.append($('<option>', {
            value: maestro.ID_MAESTRO,
            text: maestro.NOMBRE_COMPLETO
        }));
    });
}
// Actualizar paginación
function actualizarPaginacion() {
    const paginationContainer = $('#paginacion');
    paginationContainer.empty();
    
    if (totalPages <= 1) {
        return;
    }
    
    let paginationHTML = `
        <nav aria-label="Navegación de páginas">
            <ul class="pagination justify-content-center">
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Anterior">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
    `;
    
    let startPage = Math.max(1, currentPage - 2);
    let endPage = Math.min(totalPages, startPage + 4);
    
    if (endPage - startPage < 4) {
        startPage = Math.max(1, endPage - 4);
    }
    
    if (startPage > 1) {
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="#" data-page="1">1</a>
            </li>
        `;
        
        if (startPage > 2) {
            paginationHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
        }
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <li class="page-item ${i === currentPage ? 'active' : ''}">
                <a class="page-link" href="#" data-page="${i}">${i}</a>
            </li>
        `;
    }
    
    if (endPage < totalPages) {
        if (endPage < totalPages - 1) {
            paginationHTML += `
                <li class="page-item disabled">
                    <span class="page-link">...</span>
                </li>
            `;
        }
        
        paginationHTML += `
            <li class="page-item">
                <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
            </li>
        `;
    }
    
    paginationHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Siguiente">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    `;
    
    paginationContainer.html(paginationHTML);
    
    $('.page-link').on('click', function(e) {
        e.preventDefault();
        const page = $(this).data('page');
        if (page >= 1 && page <= totalPages) {
            cargarAsignaciones(page);
        }
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

// Mostrar mensaje de error en modal de eliminación
function showErrordel(message) {
    const errorContainer = document.getElementById("errorMessageContainerdel");
    const errorMessageElement = document.getElementById("errorMessagedel");
    errorMessageElement.textContent = message;
    errorContainer.classList.remove("d-none");
}

// Ocultar mensaje de error en modal de eliminación
function hideErrordel() {
    const errorContainer = document.getElementById('errorMessageContainerdel');
    errorContainer.classList.add('d-none');
}

// Inicializar cuando el documento esté listo
$(document).ready(function() {
    // Verificar que tenemos parámetros válidos
    if (!urlParams.periodo || !urlParams.grado) {
        alert('URL no válida. Debe acceder desde /administracion-grados/materias/{periodo}/{grado}');
        return;
    }
    
    // Cargar información inicial
    cargarInfoPeriodoGrado();
    cargarAsignaciones();
    cargarMaterias();
    cargarMaestros();
    
    // Botón agregar
    $("#agregar").click(function() {
        hideError();
        $("#asignacionId").val("").prop("disabled", false);
        $("#selectMateria").val("").prop("disabled", false);
        $("#selectMaestro").val("");
        $("#titulo").text("Asignar Materia a Grado");
    });
    
    // Botón editar
    $(document).on("click", ".btn-editar", function() {
        hideError();
        const id = $(this).data("id");
        const materiaId = $(this).data("materia");
        const maestroId = $(this).data("maestro");
        $("#asignacionId").val(id);
        $("#selectMateria").val(materiaId).prop('disabled', true);
        $("#selectMaestro").val(maestroId);
        $("#titulo").text("Modificar Asignación");
    });
    $(document).on("click", ".btn-eliminar", function() {
        hideErrordel();
        const id = $(this).data("id");
        const nombre = $(this).data("nombre");
        const idMateria = $(this).data("idmateria");
        $("#CodigoEliminar").text(id);
        $("#DescripcionEliminar").text(nombre);
        $("#ideliminacion").val(idMateria); 
    });

    // Botón confirmar eliminación
    $("#btnConfirmDelete").click(function() {
        const idMateria = parseInt($("#ideliminacion").val());
        const datos = {
        ID_PERIODO_ESCOLAR: parseInt(urlParams.periodo),
        ID_GRADO: parseInt(urlParams.grado),
        ID_MATERIA: idMateria, 
        ACCION: 'D'
    }; 
    console.log('Datos a enviar:', datos); // Para debug
    
    $.ajax({
        url: apiBaseUrl,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(datos),
        success: function(response) {
            if (response.mensaje === "") {
                $("#deleteModal").modal("hide");
                cargarAsignaciones(currentPage);
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

    
    // Botón guardar
    $("#btnGuardar").click(function() {
    const titulo = $("#titulo").text().trim();
    const accion = titulo === "Asignar Materia a Grado" ? "I" : "U";
    
    const datos = {
        ID_PERIODO_ESCOLAR: parseInt(urlParams.periodo),
        ID_GRADO: parseInt(urlParams.grado),
        ID_MATERIA: $("#selectMateria").val(), // Convertir a número
        ID_MAESTRO: parseInt($("#selectMaestro").val()), // Convertir a número
        ID_PERSONA_INGRESO: ID_PERSONA,
        ACCION: accion
    }; 
    console.log('Datos a enviar:', datos); // Para debug
    
    $.ajax({
        url: apiBaseUrl,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(datos),
        success: function(response) {
            if (response.mensaje === "") {
                $("#asignacionModal").modal("hide");
                cargarAsignaciones(currentPage);
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
    
    // Botón limpiar filtros
    $("#btnLimpiarFiltros").click(function() {
        $("#filtroMateria").val("");
        currentFilters = {};
        cargarAsignaciones(1);
    });
});
</script>
@endsection