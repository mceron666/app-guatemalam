@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">
<div id="header-periodos" class="mb-4" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/ruinas.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
    <i class="fas fa-graduation-cap"></i> Grados
    </div>
</div>
<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <!-- Barra de búsqueda -->
                <div class="col-md-8 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="inputBusqueda" class="form-control border-start-0" 
                               placeholder="Buscar por nombre de grado..." aria-label="Buscar grado">
                        <button id="btnBuscar" class="btn btn-success px-3">
                            Buscar
                        </button>
                        <button id="btnLimpiar" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-1"></i>Limpiar
                        </button>
                    </div>
                </div>
                
                <!-- Botón de agregar -->
                <div class="col-md-4 col-lg-6 text-md-end mt-3 mt-md-0">
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#gradoModal">
                        <i class="bi bi-plus-circle me-1"></i>Agregar
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaGrados" class="table table-bordered border-dark tabla-con-borde">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col" class="border border-dark">Código Grado</th>
                            <th scope="col" class="border border-dark">Nombre Grado</th>
                            <th scope="col" class="border border-dark">Sección</th>
                            <th scope="col" class="border border-dark">Nivel</th>
                            <th scope="col" class="border border-dark">Perfil ingreso</th>                         
                            <th scope="col" class="border border-dark">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- Table rows will be populated dynamically -->
                    </tbody>
                </table>
                <div id="paginacion" class="mt-3">
                    <!-- Pagination will be populated dynamically -->
                </div>                
            </div>
        </div>
    </div>
</div>

<div class="modal fade custom-modal" id="gradoModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header text-white" style="background-color: #198754;">
        <div class="d-flex align-items-center">
          <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
          <h4 class="modal-title" id="titulo">Ingresar Grado Académico</h4>
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
        <form id="gradoForm">
          <input type="hidden" id="gradoId" name="id">
          
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Información Básica</h5>
                  <div class="mb-4">
                    <label for="codigoGrado" class="form-label fw-semibold">Código del Grado</label>
                    <input type="text" class="form-control form-control-lg" id="codigoGrado" name="CODIGO_GRADO" maxlength="20"/>
                  </div>
                  <div class="mb-3">
                    <label for="nombreGrado" class="form-label fw-semibold">Nombre del Grado</label>
                    <input type="text" class="form-control form-control-lg" id="nombreGrado" name="NOMBRE_GRADO" maxlength="50"/>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Detalles del Grado</h5>
                  <div class="mb-4">
                    <label for="seccionGrado" class="form-label fw-semibold">Sección</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-card-list"></i></span>
                      <select class="form-select" id="seccionGrado" name="SECCION_GRADO">
                        <option value="" selected disabled>Seleccione sección</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-4">
                    <label for="nivelGrado" class="form-label fw-semibold">Nivel</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-bar-chart-steps"></i></span>
                      <select class="form-select" id="nivelGrado" name="NIVEL_GRADO">
                        <option value="" selected disabled>Seleccione nivel</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="carreraEstudiantil" class="form-label fw-semibold">Carrera Estudiantil</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-mortarboard"></i></span>
                      <select class="form-select" id="carreraEstudiantil" name="IDENTIFICADOR_CARRERA_ESTUDIANTIL">
                        <option value="" selected disabled>Seleccione una carrera</option>
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
const apiBaseUrl = 'http://localhost:3000/grados'; // URL base de la API
let currentPage = 1;
let totalPages = 1;
let currentUrl = apiBaseUrl;
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    

// Función para cargar las carreras en el dropdown
$(document).ready(function () {
    // Fetch careers when page loads
    fetchCareers();
    
    // Add event listener for career selection
    $('#carreraEstudiantil').on('change', function() {
        const selectedCarreraId = $(this).val();
        console.log('Selected career ID:', selectedCarreraId);
        // You can store this ID in a variable or use it as needed
    });
    
    // Function to fetch careers from API using AJAX
    function fetchCareers() {
        $.ajax({
            url: 'http://localhost:3000/carreras/seleccion',
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                populateCarrerasDropdown(data.data);
            },
            error: function(xhr, status, error) {
                console.error('Error fetching careers:', error);
            }
        });
    }
    
    // Function to populate the careers dropdown
    function populateCarrerasDropdown(carreras) {
        const dropdown = $('#carreraEstudiantil');
        
        // Clear existing options except the first one
        dropdown.find('option:not(:first)').remove();
        
        // Add new options
        $.each(carreras, function(index, carrera) {
            dropdown.append($('<option>', {
                value: carrera.ID_CARRERA_ESTUDIANTIL,
                text: carrera.DESCRIPCION_CARRERA
            }));
        });
    }

    // Cargar grados y configurar eventos
    cargarGrados(apiBaseUrl);
    
    $('#btnBuscar').click(function () {
        const textoBusqueda = $('#inputBusqueda').val().trim();
        const urlBusqueda = textoBusqueda ? `${apiBaseUrl}/busqueda/${encodeURIComponent(textoBusqueda)}` : apiBaseUrl;
        cargarGrados(urlBusqueda, 1); // Siempre empezar en la página 1 al realizar una búsqueda
    });

    $('#inputBusqueda').on('keypress', function(e) {
        if (e.which === 13) { // Código de tecla Enter
            $('#btnBuscar').click();
        }
    });

    $('#btnLimpiar').on('click', function() {
        $('#inputBusqueda').val('');
        cargarGrados(apiBaseUrl, 1);
    });
    
    if ($('#paginacion').length === 0) {
        $('#tablaGrados').after('<div id="paginacion" class="mt-3"></div>');
    }
    
    $("#agregar").click(() => {
        hideError();
        $("#codigoGrado").val("").prop("disabled", false);
        $("#nombreGrado").val("");
        $("#seccionGrado").val("");
        $("#nivelGrado").val("");
        $("#carreraEstudiantil").val("");
        $("#titulo").text("Ingresar Grado Académico");
    });
    
    $(document).on("click", ".btn-editar", function () {
        hideError();
        const boton = $(this);
        const codigo = boton.data("codigo");
        const nombre = boton.data("nombre");
        const seccion = boton.data("seccion");
        const nivel = boton.data("nivel");
        const carrera = boton.data("carrera");
        
        $("#codigoGrado").val(codigo).prop('disabled', true);
        $("#nombreGrado").val(nombre);
        $("#seccionGrado").val(seccion);
        $("#nivelGrado").val(nivel);
        $("#carreraEstudiantil").val(carrera);
        $("#titulo").text("Modificar Grado Académico");
    });
    
    $("#btnGuardar").click(() => {
        const titulo = document.getElementById("titulo").textContent.trim();
        const accion = titulo === "Ingresar Grado Académico" ? "I" : "U";
        const datos = {
            CODIGO_GRADO: $("#codigoGrado").val(),
            NOMBRE_GRADO: $("#nombreGrado").val(),
            SECCION_GRADO: $("#seccionGrado").val(),
            NIVEL_GRADO: $("#nivelGrado").val(),
            IDENTIFICADOR_CARRERA_ESTUDIANTIL: $("#carreraEstudiantil").val(),
            ID_PERSONA_INGRESO: ID_PERSONA,
            ACCION: accion,
        };
        
        $.ajax({
            url: apiBaseUrl,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(datos),
            success: (response) => {
                if (response.mensaje === "") {
                    $("#gradoModal").modal("hide");
                    cargarGrados(apiBaseUrl);
                } else {
                    showError(response.mensaje);
                }
            },
            error: (err) => {
                console.error(err);
                showError("Ocurrió un error en la solicitud. Por favor intente nuevamente.");
            },
        });
    });
});

function cargarGrados(url, page = 1) {
    // Construir URL con parámetros de paginación
    let urlFinal = url;
    
    // Verificar si la URL ya tiene parámetros
    if (urlFinal.includes('?')) {
        urlFinal += `&page=${page}&limit=10`;
    } else {
        urlFinal += `?page=${page}&limit=10`;
    }
    
    $.ajax({
        url: urlFinal,
        type: 'GET',
        dataType: 'json',
        cache: false, 
        success: function (response) {
            const data = response.data;
            const pagination = response.pagination;
            currentPage = pagination.currentPage;
            totalPages = pagination.totalPages;
            currentUrl = url; 
            const tbody = $('#tablaGrados tbody');
            tbody.empty(); 
            
            if (data.length === 0) {
                tbody.append('<tr><td colspan="6" class="text-center">No se encontraron grados</td></tr>');
            } else {
                data.forEach(grado => {
                    let rolDescripcion = '';
                        let rolClase = '';
                        switch (grado.SECCION_GRADO) {
                            case 'A':
                                rolClase = 'badge bg-primary';
                                break;
                            case 'B':
                                rolClase = 'badge bg-danger';
                                break;
                            case 'C':
                                rolClase = 'badge bg-success';
                                break;
                            default:
                                rolClase = 'badge bg-secondary';
                                break;
                        }                    
                    const fila = `
                        <tr>
                            <td>${grado.CODIGO_GRADO}</td>
                            <td>${grado.NOMBRE_GRADO}</td>
                            <td class="text-center">
                                <span class="${rolClase}" style="padding: 5px 10px; font-size: 14px;">
                                    ${grado.SECCION_GRADO}
                                </span>
                            </td>
                            <td>${grado.NIVEL_GRADO}</td>
                            <td>${grado.PERFIL_PERSONA}</td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <button 
                                        class="btn btn-warning btn-sm me-2 btn-editar" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#gradoModal"
                                        data-codigo="${grado.CODIGO_GRADO}"
                                        data-nombre="${grado.NOMBRE_GRADO}"
                                        data-seccion="${grado.SECCION_GRADO}"
                                        data-nivel="${grado.NIVEL_GRADO}"
                                        data-carrera="${grado.IDENTIFICADOR_CARRERA_ESTUDIANTIL}">
                                        <i class="bi bi-pencil-square"></i> Modificar
                                    </button>
                                    <button data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            class="btn btn-danger btn-sm btn-eliminar" 
                                            data-id="${grado.CODIGO_GRADO}" 
                                            data-nombre="${grado.NOMBRE_GRADO}">
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
        error: function (error) {
            console.error('Error al cargar los Grados:', error);
            $('#tablaGrados tbody').html('<tr><td colspan="6" class="text-center">Error al cargar datos</td></tr>');
        }
    });
}

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
            cargarGrados(currentUrl, page);
        }
    });
}

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
function showErrordel(message) {
    const errorContainer = document.getElementById("errorMessageContainerdel");
    const errorMessageElement = document.getElementById("errorMessagedel");
    errorMessageElement.textContent = message;
    errorContainer.classList.remove("d-none");
}

function hideErrordel() {
    const errorContainer = document.getElementById('errorMessageContainerdel');
    errorContainer.classList.add('d-none');
}
$(document).on("click", ".btn-eliminar", function () {
  hideErrordel();
  const boton = $(this);
  const codigo = boton.data("id");
  const descripcion = boton.data("nombre");
  $("#CodigoEliminar").text(codigo);
  $("#DescripcionEliminar").text(descripcion);
});
$("#btnConfirmDelete").click(() => {
    const datos = {
        CODIGO_GRADO: $("#CodigoEliminar").text().trim(),
        NOMBRE_GRADO: null,
        SECCION_GRADO: null, 
        NIVEL_GRADO : null,
        ID_PERSONA_INGRESO : null,
        ACCION: "D"
    };
    $.ajax({
        url: apiBaseUrl,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(datos),
        success: (response) => {
            if (response.mensaje === "") {
                $("#deleteModal").modal("hide");
                cargarGrados(currentUrl, currentPage);
            } else {
                showErrordel(response.mensaje);
            }
        },
        error: (err) => {
            console.error(err);
            showErrordel("Ocurrió un error en la solicitud. Por favor intente nuevamente.");
        }
    });
});
</script>
@endsection
