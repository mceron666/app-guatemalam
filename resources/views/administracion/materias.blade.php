@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">
<script src="/js/pagineo.js"></script>
<div id="header-periodos" class="mb-4" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/ruinas.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
    <i class="fas fa-book"></i> Materias
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
                               placeholder="Buscar por nombre de materia..." aria-label="Buscar materia">
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
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#materiaModal">
                        <i class="bi bi-plus-circle me-1"></i>Agregar
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaMaterias" class="table table-bordered border-dark tabla-con-borde">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col" class="border border-dark">Código Materia</th>
                            <th scope="col" class="border border-dark">Nombre Materia</th>
                            <th scope="col" class="border border-dark">Color</th>
                            <th scope="col" class="border border-dark">Estado</th>
                            <th scope="col" class="border border-dark">Perfil ingreso</th>
                            <th scope="col" class="border border-dark">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <!-- Table rows will be populated dynamically -->
                        <tr>
                        </tr>
                    </tbody>
                </table>
                <div id="paginacion" class="mt-3">
                </div>                
            </div>
        </div>
    </div>
</div>
<div class="modal fade custom-modal" id="materiaModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header text-white" style="background-color: #198754;">
        <div class="d-flex align-items-center">
          <img src="{{ asset('images/image.webp') }}" alt="Icono" width="45" height="45" class="me-2">
          <h4 class="modal-title" id="titulo">Ingresar Materia</h4>
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
        <form id="materiaForm">
          @csrf
          <input type="hidden" id="editMode" name="editMode" value="0">
          
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="codigoMateria" class="form-label">Código</label>
              <input type="text" class="form-control" id="codigoMateria" name="CODIGO_MATERIA" maxlength="15"/>
            </div>
            <div class="col-md-6">
              <label for="nombreMateria" class="form-label">Nombre</label>
              <input type="text" class="form-control" id="nombreMateria" name="NOMBRE_MATERIA" maxlength="50"/>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col-md-4">
              <label for="colorMateria" class="form-label">Color</label>
              <div class="d-flex">
                <input type="color" class="form-control form-control-color me-2" id="colorMateria" name="COLOR_MATERIA" value="#198754" style="width: 50px;">
                <input type="text" class="form-control" id="colorMateriaText" placeholder="#198754" maxlength="7" style="font-family: monospace; font-size: 12px;">
              </div>
            </div>
            
            <div class="col-md-3">
              <label class="form-label">Letras Blancas</label>
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" id="usaLetrasBlancas" name="USA_LETRAS_BLANCAS">
                <label class="form-check-label" for="usaLetrasBlancas" id="labelLetrasBlancas">No</label>
              </div>
            </div>
            
            <div class="col-md-3">
              <label class="form-label">Estado</label>
              <div class="form-check form-switch mt-2">
                <input class="form-check-input" type="checkbox" id="estadoMateria" name="ESTADO_MATERIA" checked>
                <label class="form-check-label" for="estadoMateria" id="labelEstadoMateria">Activo</label>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <label class="form-label">Vista Previa</label>
              <div id="colorPreview" class="border rounded px-3 py-2" style="background-color: #198754; color: black; text-align: center;">
                Ejemplo de Materia
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
          <i class="bi bi-x-circle me-1"></i>Cancelar
        </button>
        <button type="submit" class="btn btn-success" id="btnGuardar">
          <i class="bi bi-check-circle me-1"></i>Guardar
        </button>
      </div>
    </div>
  </div>
</div>
<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    
const apiBaseUrl = 'http://localhost:3000/materias'; // URL base de la API
    let currentPage = 1;
    let totalPages = 1;
    let currentUrl = apiBaseUrl;
    
    function cargarmaterias(url, page = 1) {
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
                const tbody = $('#tablaMaterias tbody');
                tbody.empty(); 
                
                if (data.length === 0) {
                    tbody.append('<tr><td colspan="6" class="text-center">No se encontró materia</td></tr>');
                } else {
                    data.forEach(materia => {
                        const colorStyle = materia.COLOR_MATERIA ? `background-color: ${materia.COLOR_MATERIA}; color: ${materia.USA_LETRAS_BLANCAS === 'Y' ? 'white' : 'black'};` : '';
                        const fila = `
                            <tr>
                                <td>${materia.CODIGO_MATERIA}</td>
                                <td>${materia.NOMBRE_MATERIA}</td>
                                <td>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <div class="rounded px-2 py-1 me-2" style="${colorStyle} min-width: 80px; text-align: center; border: 1px solid #dee2e6;">
                                            ${materia.NOMBRE_MATERIA || 'Ejemplo'}
                                        </div>
                                        <small class="text-muted">${materia.COLOR_MATERIA || '#000000'}</small>
                                    </div>
                                </td>
                                <td>${materia.DESCRIPCION_ESTADO_MATERIA}</td>
                                <td>${materia.ID_PERSONA_INGRESO}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button 
                                            class="btn btn-warning btn-sm me-2 btn-editar" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#materiaModal"
                                            data-codigo="${materia.CODIGO_MATERIA}"
                                            data-descripcion="${materia.NOMBRE_MATERIA}"
                                            data-color="${materia.COLOR_MATERIA || '#198754'}"
                                            data-letras-blancas="${materia.USA_LETRAS_BLANCAS || 'N'}"
                                            data-estado="${materia.ESTADO_MATERIA || 'A'}">
                                            <i class="bi bi-pencil-square"></i> Modificar
                                    </button>
                                    <button data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal" 
                                            class="btn btn-danger btn-sm btn-eliminar" 
                                            data-id="${materia.CODIGO_MATERIA}" 
                                            data-nombre="${materia.NOMBRE_MATERIA}">
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
                console.error('Error al cargar las Materias:', error);
                $('#tablaMaterias tbody').html('<tr><td colspan="6" class="text-center">Error al cargar datos</td></tr>');
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
            cargarmaterias(currentUrl, page);
        }
    });
}    

// Función para actualizar la vista previa del color
function actualizarVistaPrevia() {
    const color = $('#colorMateria').val();
    const usaLetrasBlancas = $('#usaLetrasBlancas').is(':checked');
    const textColor = usaLetrasBlancas ? 'white' : 'black';
    
    $('#colorPreview').css({
        'background-color': color,
        'color': textColor
    });
    
    $('#colorMateriaText').val(color.toUpperCase());
}

// Función para actualizar etiquetas de switches
function actualizarEtiquetas() {
    const usaLetrasBlancas = $('#usaLetrasBlancas').is(':checked');
    const estadoActivo = $('#estadoMateria').is(':checked');
    
    $('#labelLetrasBlancas').text(usaLetrasBlancas ? 'Sí' : 'No');
    $('#labelEstadoMateria').text(estadoActivo ? 'Activo' : 'Inactivo');
}

$(document).ready(function () {
    cargarmaterias(apiBaseUrl)

    // Event listeners para el selector de color
    $('#colorMateria').on('input change', actualizarVistaPrevia);
    
    $('#colorMateriaText').on('input', function() {
        const colorValue = $(this).val();
        if (/^#[0-9A-F]{6}$/i.test(colorValue)) {
            $('#colorMateria').val(colorValue);
            actualizarVistaPrevia();
        }
    });
    
    // Event listeners para los switches
    $('#usaLetrasBlancas').on('change', function() {
        actualizarEtiquetas();
        actualizarVistaPrevia();
    });
    
    $('#estadoMateria').on('change', actualizarEtiquetas);

    $('#btnBuscar').click(function () {
        const textoBusqueda = $('#inputBusqueda').val().trim();
        const urlBusqueda = textoBusqueda ? `${apiBaseUrl}/busqueda/${encodeURIComponent(textoBusqueda)}` : apiBaseUrl;
        cargarmaterias(urlBusqueda, 1); // Siempre empezar en la página 1 al realizar una búsqueda
    });

    $('#inputBusqueda').on('keypress', function(e) {
        if (e.which === 13) { // Código de tecla Enter
            $('#btnBuscar').click();
        }
    });

    $('#btnLimpiar').on('click', function() {
        $('#inputBusqueda').val('');
        cargarmaterias(apiBaseUrl, 1);
    });    
    
    if ($('#paginacion').length === 0) {
        $('#tablaMaterias').after('<div id="paginacion" class="mt-3"></div>');
    }
})

$("#agregar").click(() => {
    hideError()
    $("#codigoMateria").val("").prop("disabled", false)
    $("#nombreMateria").val("")
    $("#colorMateria").val("#198754")
    $("#colorMateriaText").val("#198754")
    $("#usaLetrasBlancas").prop("checked", false)
    $("#estadoMateria").prop("checked", true)
    $("#titulo").text("Ingresar materia")
    actualizarEtiquetas()
    actualizarVistaPrevia()
})

$(document).on("click", ".btn-editar", function () {
    hideError()
    const boton = $(this)
    const codigo = boton.data("codigo")
    const descripcion = boton.data("descripcion")
    const color = boton.data("color") || "#198754"
    const letrasBlancas = boton.data("letras-blancas") === "Y"
    const estado = boton.data("estado") === "A"
    
    $("#codigoMateria").val(codigo).prop('disabled', true)
    $("#nombreMateria").val(descripcion)
    $("#colorMateria").val(color)
    $("#colorMateriaText").val(color.toUpperCase())
    $("#usaLetrasBlancas").prop("checked", letrasBlancas)
    $("#estadoMateria").prop("checked", estado)
    $("#titulo").text("Modificar materia")
    
    actualizarEtiquetas()
    actualizarVistaPrevia()
})

$("#btnGuardar").click(() => {
    const titulo = document.getElementById("titulo").textContent.trim()
    const accion = titulo === "Ingresar materia" ? "I" : "U"
    const datos = {
        CODIGO_MATERIA: $("#codigoMateria").val(),
        NOMBRE_MATERIA: $("#nombreMateria").val(),
        COLOR_MATERIA: $("#colorMateria").val(),
        USA_LETRAS_BLANCAS: $("#usaLetrasBlancas").is(':checked') ? "Y" : "N",
        ESTADO_MATERIA: $("#estadoMateria").is(':checked') ? "A" : "I",
        ID_PERSONA_INGRESO: ID_PERSONA,
        ACCION: accion,
    }
    
    $.ajax({
        url: "http://localhost:3000/materias",
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(datos),
        success: (response) => {
            if (response.mensaje === "") {
                $("#materiaModal").modal("hide")
                cargarmaterias("http://localhost:3000/materias")
            } else {
                showError(response.mensaje)
            }
        },
        error: (err) => {
            console.error(err)
            showError("Ocurrió un error en la solicitud. Por favor intente nuevamente.")
        },
    })
})

function showError(message) {
    const errorContainer = document.getElementById("errorMessageContainer")
    const errorMessageElement = document.getElementById("errorMessage")
    errorMessageElement.textContent = message
    errorContainer.classList.remove("d-none")
}

function hideError() {
    const errorContainer = document.getElementById('errorMessageContainer');
    errorContainer.classList.add('d-none');
};

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
        CODIGO_MATERIA: $("#CodigoEliminar").text().trim(),
        NOMBRE_MATERIA: null,
        COLOR_MATERIA: null,
        USA_LETRAS_BLANCAS: null,
        ESTADO_MATERIA: null,
        ID_PERSONA_INGRESO: null, 
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
                cargarmaterias(currentUrl, currentPage);
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