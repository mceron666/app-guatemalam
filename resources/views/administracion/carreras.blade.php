@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<!-- Imagen -->
<link href="/css/modal.css" rel="stylesheet">
<div id="header-periodos" class="mb-4" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/ruinas.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
    <i class="bi bi-mortarboard"></i> Carreras
    </div>
</div>
<!-- Tabla -->
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
                               placeholder="Buscar por descripción de carrera..." aria-label="Buscar carrera">
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
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#carreraModal">
                        <i class="bi bi-plus-circle me-1"></i>Agregar
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaCarreras" class="table table-bordered border-dark tabla-con-borde">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col" class="border border-dark">Código Carrera</th>
                            <th scope="col" class="border border-dark">Descripción Carrera</th>
                            <th scope="col" class="border border-dark">Tipo Carrera</th>
                            <th scope="col" class="border border-dark">Años Duración</th>
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


<div class="modal fade custom-modal" id="carreraModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header text-white" style="background-color: #198754;">
        <div class="d-flex align-items-center">
          <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
          <h4 class="modal-title" id="titulo">Ingresar Carrera Estudiantil</h4>
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
        <form id="carreraForm">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Información Básica</h5>
                  <div class="mb-4">
                    <label for="codigoCarrera" class="form-label fw-semibold">Código de la Carrera</label>
                    <input type="text" class="form-control form-control-lg" id="codigoCarrera" name="CODIGO_CARRERA" maxlength="15"/>
                  </div>
                  <div class="mb-3">
                    <label for="descripcionCarrera" class="form-label fw-semibold">Descripción de la Carrera</label>
                    <input type="text" class="form-control form-control-lg" id="descripcionCarrera" name="DESCRIPCION_CARRERA" maxlength="50"/>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Detalles de la Carrera</h5>
                  <div class="mb-4">
                  <label for="aniosDuracion" class="form-label fw-semibold">Años de Duración</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-calendar3"></i></span>
                      <select class="form-select" id="aniosDuracion" name="ANIOS_DURACION">
                        <option value="" selected disabled>Seleccione duración</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                      </select>
                    </div>
                  </div>
                  <div class="mb-3">
                  <label for="tipoCarrera" class="form-label fw-semibold">Tipo de Carrera</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-mortarboard"></i></span>
                        <select class="form-select" id="tipoCarrera" name="TIPO_CARRERA">
                        <option value="" selected disabled>Seleccione un tipo</option>
                        <option value="B">Bachiller</option>
                        <option value="P">Perito</option>
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
        <button type="submit" class="btn btn-success btn-lg px-4" id="btnGuardar">
          <i class="bi bi-check-circle me-2"></i>Guardar
        </button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                ¿Está seguro que desea eliminar esta carrera? Esta acción no se puede deshacer.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btnConfirmDelete">Eliminar</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};      
$(document).ready(function () {
    const apiBaseUrl = "http://localhost:3000/carreras" // URL base de la API para carreras
  let currentPage = 1
  let totalPages = 1
  let currentUrl = apiBaseUrl

  // Función para cargar carreras con paginación
  function cargarCarreras(url, page = 1) {
    // Construir URL con parámetros de paginación
    let urlFinal = url

    // Verificar si la URL ya tiene parámetros
    if (urlFinal.includes("?")) {
      urlFinal += `&page=${page}&limit=10`
    } else {
      urlFinal += `?page=${page}&limit=10`
    }

    $.ajax({
      url: urlFinal,
      type: "GET",
      dataType: "json",
      cache: false,
      success: (response) => {
        const data = response.data
        const pagination = response.pagination

        // Actualizar variables de paginación
        currentPage = pagination.currentPage
        totalPages = pagination.totalPages
        currentUrl = url // Guardar la URL base actual (sin parámetros de paginación)

        const tbody = $("#tablaCarreras tbody")
        tbody.empty()

        if (data.length === 0) {
          tbody.append('<tr><td colspan="7" class="text-center">No se encontraron carreras</td></tr>')
        } else {
          data.forEach((carrera) => {
            const estadoBadge =
              carrera.ESTADO_CARRERA_ESTUDIANTIL === "A" ? "badge bg-success text-white" : "badge bg-danger text-white"

            const fila = `
                            <tr>
                                <td>${carrera.CODIGO_CARRERA}</td>
                                <td>${carrera.DESCRIPCION_CARRERA}</td>
                                <td>${carrera.DESCRIPCION_TIPO_CARRERA}</td>
                                <td>${carrera.ANIOS_DURACION}</td>
                                <td>${carrera.PERFIL_PERSONA}</td>                            
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button 
                                            class="btn btn-warning btn-sm me-2 btn-editar" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#carreraModal"
                                            data-codigo="${carrera.CODIGO_CARRERA}"
                                            data-descripcion="${carrera.DESCRIPCION_CARRERA}"
                                            data-tipo="${carrera.TIPO_CARRERA}"
                                            data-anios="${carrera.ANIOS_DURACION}">
                                            <i class="bi bi-pencil-square"></i> Modificar
                                        </button>
                                        <button data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal" 
                                                class="btn btn-danger btn-sm btn-eliminar" 
                                                data-id="${carrera.CODIGO_CARRERA}" 
                                                data-nombre="${carrera.DESCRIPCION_CARRERA}">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `
            tbody.append(fila)
          })
        }

        // Actualizar controles de paginación
        actualizarPaginacion()
      },
      error: (error) => {
        console.error("Error al cargar las carreras:", error)
        $("#tablaCarreras tbody").html('<tr><td colspan="7" class="text-center">Error al cargar datos</td></tr>')
      },
    })
  }

  // Función para actualizar los controles de paginación
  function actualizarPaginacion() {
    const paginationContainer = $("#paginacion")
    paginationContainer.empty()

    if (totalPages <= 1) {
      return
    }

    // Crear HTML de paginación
    let paginationHTML = `
            <nav aria-label="Navegación de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item ${currentPage === 1 ? "disabled" : ""}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
        `

    // Mostrar máximo 5 páginas a la vez
    let startPage = Math.max(1, currentPage - 2)
    const endPage = Math.min(totalPages, startPage + 4)

    // Ajustar si estamos cerca del final
    if (endPage - startPage < 4) {
      startPage = Math.max(1, endPage - 4)
    }

    // Mostrar primera página y elipsis si es necesario
    if (startPage > 1) {
      paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="1">1</a>
                </li>
            `

      if (startPage > 2) {
        paginationHTML += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `
      }
    }

    // Generar números de página
    for (let i = startPage; i <= endPage; i++) {
      paginationHTML += `
                <li class="page-item ${i === currentPage ? "active" : ""}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `
    }

    // Mostrar última página y elipsis si es necesario
    if (endPage < totalPages) {
      if (endPage < totalPages - 1) {
        paginationHTML += `
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                `
      }

      paginationHTML += `
                <li class="page-item">
                    <a class="page-link" href="#" data-page="${totalPages}">${totalPages}</a>
                </li>
            `
    }

    paginationHTML += `
                    <li class="page-item ${currentPage === totalPages ? "disabled" : ""}">
                        <a class="page-link" href="#" data-page="${currentPage + 1}" aria-label="Siguiente">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        `

    paginationContainer.html(paginationHTML)

    // Agregar event listeners a los enlaces de paginación
    $(".page-link").on("click", function (e) {
      e.preventDefault()
      const page = $(this).data("page")
      if (page >= 1 && page <= totalPages) {
        cargarCarreras(currentUrl, page)
      }
    })
  }

  // Cargar carreras al iniciar la página
  cargarCarreras(apiBaseUrl)
    
    // Manejar la búsqueda
    $('#btnBuscar').click(function () {
        const textoBusqueda = $('#inputBusqueda').val().trim();
        const urlBusqueda = textoBusqueda ? `${apiBaseUrl}/busqueda/${encodeURIComponent(textoBusqueda)}` : apiBaseUrl;
        cargarCarreras(urlBusqueda, 1); // Siempre empezar en la página 1 al realizar una búsqueda
    });
    
    // También permitir búsqueda al presionar Enter en el campo de búsqueda
    $('#inputBusqueda').on('keypress', function(e) {
        if (e.which === 13) { // Código de tecla Enter
            $('#btnBuscar').click();
        }
    });
    
    // Botón para limpiar la búsqueda y mostrar todos los registros
    $('#btnLimpiar').on('click', function() {
        $('#inputBusqueda').val('');
        cargarCarreras(apiBaseUrl, 1);
    });
    
    // Carga inicial
    
    // Agregar un div para la paginación después de la tabla si no existe
    if ($('#paginacion').length === 0) {
        $('#tablaCarreras').after('<div id="paginacion" class="mt-3"></div>');
    }
$("#agregar").click(() => {
  hideError()
  $("#codigoCarrera").val("").prop("disabled", false)
  $("#descripcionCarrera").val("")
  $("#tipoCarrera").val("").prop("selectedIndex", 0) // Reset dropdown to first option
  $("#aniosDuracion").val("").prop("selectedIndex", 0) // Reset dropdown to first option
  $("#titulo").text("Ingresar Carrera Estudiantil")
})
$(document).on("click", ".btn-editar", function () {
  hideError()
  const boton = $(this)
  const codigo = boton.data("codigo")
  const descripcion = boton.data("descripcion")
  const tipo = boton.data("tipo")
  const anios = boton.data("anios")

  $("#codigoCarrera").val(codigo).prop('disabled', true)
  $("#descripcionCarrera").val(descripcion)
  $("#tipoCarrera").val(tipo)
  $("#aniosDuracion").val(anios)
  $("#titulo").text("Modificar Carrera Estudiantil")
})
$("#btnGuardar").click(() => {
  const titulo = document.getElementById("titulo").textContent.trim()
  const accion = titulo === "Ingresar Carrera Estudiantil" ? "I" : "U"

  // Get form values
  const tipoCarrera = $("#tipoCarrera").val()
  const aniosDuracion = $("#aniosDuracion").val()

  const datos = {
    CODIGO_CARRERA: $("#codigoCarrera").val(),
    DESCRIPCION_CARRERA: $("#descripcionCarrera").val(),
    // Send the character value (B or P) or null if not selected
    TIPO_CARRERA: tipoCarrera ? tipoCarrera : null, // tipoCarrera should already be 'B' or 'P'
    ANIOS_DURACION: aniosDuracion ? Number.parseInt(aniosDuracion) : null,
    ID_PERSONA_INGRESO: ID_PERSONA,
    ACCION: accion,
  }

  $.ajax({
    url: "http://localhost:3000/carreras",
    type: "POST",
    contentType: "application/json",
    data: JSON.stringify(datos),
    success: (response) => {
      if (response.mensaje === "") {
        // Éxito
        $("#carreraModal").modal("hide")
        cargarCarreras("http://localhost:3000/carreras")
        // Opcional: mostrar mensaje de éxito con toast o notificación
      } else {
        // Mostrar el mensaje de error de la API en el contenedor de errores
        showError(response.mensaje)
      }
    },
    error: (err) => {
      console.error(err)
      // Mostrar mensaje de error genérico en el contenedor de errores
      showError("Ocurrió un error en la solicitud. Por favor intente nuevamente.")
    },
  })
})

// Función para mostrar mensajes de error
function showError(message) {
  const errorContainer = document.getElementById("errorMessageContainer")
  const errorMessageElement = document.getElementById("errorMessage")

  errorMessageElement.textContent = message
  errorContainer.classList.remove("d-none")
}

// Función para ocultar mensajes de error
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
      CODIGO_CARRERA: $("#CodigoEliminar").text().trim(),
      DESCRIPCION_CARRERA: null,
      TIPO_CARRERA: null,
      ANIOS_DURACION: null,
      ID_PERSONA_INGRESO: null,
      ACCION: "D"
    };
    $.ajax({
      url: apiBaseUrl, // Usar la variable del scope
      type: "POST",
      contentType: "application/json",
      data: JSON.stringify(datos),
      success: (response) => {
        if (response.mensaje === "") {
          $("#deleteModal").modal("hide");
          cargarCarreras(apiBaseUrl); // Ahora SÍ puede acceder a la función
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
});
</script>


@endsection
