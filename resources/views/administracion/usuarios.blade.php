@extends("layouts.header")

@section("contenido")
@include('general.modal-eliminacion')
<link href="/css/modal.css" rel="stylesheet">
<div class="header-section">
    <div class="header-title">
        <i class="fas fa-users"></i>
        <span>Usuarios</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>
</div> 
<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
        <div class="row mb-4 align-items-center">
                <!-- Título de la sección -->
                <!-- Barra de búsqueda -->
                <div class="col-md-8 col-lg-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="inputBusqueda" class="form-control border-start-0" 
                               placeholder="Buscar por nombre persona" aria-label="Buscar persona">
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
                    <button type="button" class="btn btn-primary" id="agregar">
                        <i class="bi bi-plus-circle me-1"></i>Agregar
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablausuarios" class="table table-bordered tabla-con-borde">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Perfil</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Número</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Perfil ingreso</th>                            
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
<script>
$(document).ready(function () {
    const apiBaseUrl = 'http://localhost:3000/personas'; // URL base de la API
    let currentPage = 1;
    let totalPages = 1;
    let currentUrl = apiBaseUrl;
    
    // Función para cargar períodos con paginación
    function cargarusuarios(url, page = 1) {
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
                
                // Actualizar variables de paginación
                currentPage = pagination.currentPage;
                totalPages = pagination.totalPages;
                currentUrl = url; // Guardar la URL base actual (sin parámetros de paginación)
                
                const tbody = $('#tablausuarios tbody');
                tbody.empty(); 
                
                if (data.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No se encontró personal</td></tr>');
                } else {
                    data.forEach(persona => {
                        let rolDescripcion = '';
                        let rolClase = '';
                        switch (persona.ROL_PERSONA) {
                            case 'A':
                                rolDescripcion = 'Alumno';
                                rolClase = 'badge bg-primary';
                                break;
                            case 'G':
                                rolDescripcion = 'Administrador';
                                rolClase = 'badge bg-danger';
                                break;
                            case 'M':
                                rolDescripcion = 'Maestro';
                                rolClase = 'badge bg-success';
                                break;
                            case 'P':
                                rolDescripcion = 'Maestro administrador';
                                rolClase = 'badge bg-warning text-dark';
                                break;
                            default:
                                rolDescripcion = 'Desconocido';
                                rolClase = 'badge bg-secondary';
                                break;
                        }
                        const fila = `
                            <tr>
                                <td>${persona.PERFIL_PERSONA}</td>
                                <td>${persona.NOMBRE_COMPLETO}</td>
                                <td>${persona.CORREO_PERSONA}</td>
                                <td>${persona.NUMERO_PERSONA}</td>
                                <td class="text-center">
                                    <span class="${rolClase}" style="padding: 5px 10px; font-size: 14px;">
                                        ${rolDescripcion}
                                    </span>
                                </td>
                                <td>${persona.PERFIL_PERSONA_INGRESO}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button 
                                            class="btn btn-warning btn-sm me-2 btn-editar" 
                                            onclick="window.location.href='/modificar-usuario/${persona.PERFIL_PERSONA}'">
                                            <i class="bi bi-pencil-square"></i> Modificar
                                        </button>
                                        <button data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal" 
                                                class="btn btn-danger btn-sm btn-eliminar" 
                                                data-id="${persona.PERFIL_PERSONA}" 
                                                data-nombre="${persona.NOMBRE_COMPLETO}">
                                            <i class="bi bi-trash"></i> Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        `;
                        tbody.append(fila);

                    });
                }
                // Actualizar controles de paginación
                actualizarPaginacion();
            },
            error: function (error) {
                console.error('Error al cargar los usuarios:', error);
                $('#tablausuarios tbody').html('<tr><td colspan="7" class="text-center">Error al cargar datos</td></tr>');
            }
        });
    }
    
    // Función para actualizar los controles de paginación
    function actualizarPaginacion() {
        const paginationContainer = $('#paginacion');
        paginationContainer.empty();
        
        if (totalPages <= 1) {
            return;
        }
        
        // Crear HTML de paginación
        let paginationHTML = `
            <nav aria-label="Navegación de páginas">
                <ul class="pagination justify-content-center">
                    <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                        <a class="page-link" href="#" data-page="${currentPage - 1}" aria-label="Anterior">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
        `;
        
        // Mostrar máximo 5 páginas a la vez
        let startPage = Math.max(1, currentPage - 2);
        let endPage = Math.min(totalPages, startPage + 4);
        
        // Ajustar si estamos cerca del final
        if (endPage - startPage < 4) {
            startPage = Math.max(1, endPage - 4);
        }
        
        // Mostrar primera página y elipsis si es necesario
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
        
        // Generar números de página
        for (let i = startPage; i <= endPage; i++) {
            paginationHTML += `
                <li class="page-item ${i === currentPage ? 'active' : ''}">
                    <a class="page-link" href="#" data-page="${i}">${i}</a>
                </li>
            `;
        }
        
        // Mostrar última página y elipsis si es necesario
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
        
        // Agregar event listeners a los enlaces de paginación
        $('.page-link').on('click', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            if (page >= 1 && page <= totalPages) {
                cargarusuarios(currentUrl, page);
            }
        });
    }
    
    // Manejar la búsqueda
    $('#btnBuscar').click(function () {
        const textoBusqueda = $('#inputBusqueda').val().trim();
        const urlBusqueda = textoBusqueda ? `${apiBaseUrl}/busqueda/${encodeURIComponent(textoBusqueda)}` : apiBaseUrl;
        cargarusuarios(urlBusqueda, 1); // Siempre empezar en la página 1 al realizar una búsqueda
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
        cargarusuarios(apiBaseUrl, 1);
    });
    
    // Carga inicial
    cargarusuarios(apiBaseUrl);
    
    // Agregar un div para la paginación después de la tabla si no existe
    if ($('#paginacion').length === 0) {
        $('#tablausuarios').after('<div id="paginacion" class="mt-3"></div>');
    }
$('#agregar').click(function () {
    window.location.href = '/agregar-usuario';
});
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
  NOMBRES_PERSONA: null,
  APELLIDOS_PERSONA: null,
  CORREO_PERSONA: null,
  PERFIL_PERSONA: $("#CodigoEliminar").text().trim(),
  SEXO_PERSONA: null,
  ROL_PERSONA: null,
  NUMERO_PERSONA: null,
  ID_PERSONA_INGRESO: null,
  ESPECIALIDAD: null,
  TITULO_ACADEMICO: null,
  SALARIO_ACTUAL: null,
  NUMERO_DPI: null,
  NOMBRE_CONTACTO_1: null,
  NUMERO_CONTACTO_1: null,
  NOMBRE_CONTACTO_2: null,
  NUMERO_CONTACTO_2: null,
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
                cargarusuarios(currentUrl, currentPage);
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

