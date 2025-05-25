@extends("layouts.header")

@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<!-- Imagen -->
<div id="header-periodos" class="mb-4" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/ruinas.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
    <i class="fas fa-calendar-alt"> </i>  Períodos Escolares
    </div>
</div> 
<!-- Tabla -->
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
                               placeholder="Buscar por descripción de período..." aria-label="Buscar período">
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
                    <button type="button" class="btn btn-primary" id="agregar" data-bs-toggle="modal" data-bs-target="#periodoModal">
                        <i class="bi bi-plus-circle me-1"></i>Agregar
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaPeriodos" class="table table-bordered tabla-con-borde">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Código Período</th>
                            <th scope="col">Descripción</th>
                            <th scope="col">Fecha de Inicio</th>
                            <th scope="col">Fecha Finaliza</th>
                            <th scope="col">Estado Período</th>
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
<!-- <div class="modal fade custom-modal" id="periodoModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow-lg">
      <div class="modal-header text-white" style="background-color: #198754;">
        <div class="d-flex align-items-center">
          <img src="/images/image.webp" alt="Icono" width="45" height="45" class="me-2">
          <h4 class="modal-title" id="titulo">Ingresar Período Escolar</h4>
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
        <form id="periodoForm">
          <div class="row g-4">
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Información Básica</h5>
                  <div class="mb-4">
                    <label for="codigoPeriodo" class="form-label fw-semibold">Código del Período</label>
                    <input type="text" class="form-control form-control-lg" id="codigoPeriodo" name="CODIGO_PERIODO"/>
                  </div>
                  <div class="mb-3">
                    <label for="descripcionPeriodo" class="form-label fw-semibold">Descripción del Período</label>
                    <input type="text" class="form-control form-control-lg" id="descripcionPeriodo" name="DESCRIPCION_PERIODO"/>
                  </div>
                </div>
              </div>
            </div>
            
            <div class="col-md-6">
              <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                  <h5 class="card-title mb-3">Fechas del Período</h5>
                  <div class="mb-4">
                    <label for="fechaInicioPeriodo" class="form-label fw-semibold">Fecha de Inicio</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
                      <input type="date" class="form-control" id="fechaInicioPeriodo" name="FECHA_INICIO_PERIODO">
                    </div>
                  </div>
                  <div class="mb-3">
                    <label for="fechaFinalizaPeriodo" class="form-label fw-semibold">Fecha de Finalización</label>
                    <div class="input-group input-group-lg">
                      <span class="input-group-text bg-light"><i class="bi bi-calendar-date"></i></span>
                      <input type="date" class="form-control" id="fechaFinalizaPeriodo" name="FECHA_FINALIZA_PERIODO">
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
</div> -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};        
$(document).ready(function () {
    const apiBaseUrl = 'http://localhost:3000/periodos'; // URL base de la API
    let currentPage = 1;
    let totalPages = 1;
    let currentUrl = apiBaseUrl;
    
    // Función para cargar períodos con paginación
    function cargarPeriodos(url, page = 1) {
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
                
                const tbody = $('#tablaPeriodos tbody');
                tbody.empty(); 
                
                if (data.length === 0) {
                    tbody.append('<tr><td colspan="7" class="text-center">No se encontraron períodos</td></tr>');
                } else {
                    data.forEach(periodo => {
                        const estadoBadge = periodo.ESTADO_PERIODO === 'A' 
                            ? 'badge bg-success text-white' 
                            : 'badge bg-danger text-white';
                        
                        const fila = `
                            <tr>
                                <td>${periodo.CODIGO_PERIODO}</td>
                                <td>${periodo.DESCRIPCION_PERIODO}</td>
                                <td>${periodo.FECHA_INICIO_PERIODO}</td>
                                <td>${periodo.FECHA_FINALIZA_PERIODO}</td>                            
                                <td class="text-center">
                                    <span class="${estadoBadge}" style="padding: 5px 10px; font-size: 14px;">
                                        ${periodo.DESCRIPCION_ESTADO_PERIODO}
                                    </span>
                                </td>
                                <td>${periodo.PERFIL_PERSONA}</td>
                                <td>
                                    <div class="d-flex justify-content-center align-items-center">
                                        <button 
                                            class="btn btn-warning btn-sm me-2 btn-editar" 
                                            onclick="window.location.href='/modificar-periodo/${periodo.CODIGO_PERIODO}'">
                                            <i class="bi bi-pencil-square"></i> Modificar
                                        </button>
                                        <button class="btn btn-danger btn-sm">
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
                console.error('Error al cargar los periodos:', error);
                $('#tablaPeriodos tbody').html('<tr><td colspan="7" class="text-center">Error al cargar datos</td></tr>');
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
                cargarPeriodos(currentUrl, page);
            }
        });
    }
    
    // Manejar la búsqueda
    $('#btnBuscar').click(function () {
        const textoBusqueda = $('#inputBusqueda').val().trim();
        const urlBusqueda = textoBusqueda ? `${apiBaseUrl}/busqueda/${encodeURIComponent(textoBusqueda)}` : apiBaseUrl;
        cargarPeriodos(urlBusqueda, 1); // Siempre empezar en la página 1 al realizar una búsqueda
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
        cargarPeriodos(apiBaseUrl, 1);
    });
    
    // Carga inicial
    cargarPeriodos(apiBaseUrl);
    
    // Agregar un div para la paginación después de la tabla si no existe
    if ($('#paginacion').length === 0) {
        $('#tablaPeriodos').after('<div id="paginacion" class="mt-3"></div>');
    }
    $('#agregar').click(function () {
    window.location.href = '/agregar-periodo';
    });
// $(document).on('click', '.btn-editar', function () {
//     hideError();
//     const boton = $(this);
//     const codigo = boton.data('codigo');
//     const descripcion = boton.data('descripcion');
//     const inicio = boton.data('inicio');
//     const fin = boton.data('fin');

//     $('#codigoPeriodo').val(codigo).prop('disabled', true);
//     $('#descripcionPeriodo').val(descripcion);
//     $('#fechaInicioPeriodo').val(inicio);
//     $('#fechaFinalizaPeriodo').val(fin);
//     $('#titulo').text('Modificar período');
// });
// $('#btnGuardar').click(function () {    
//     const titulo = document.getElementById("titulo").textContent.trim();
//     const accion = titulo === "Ingresar período" ? "I" : "U";

//     // Get date values
//     const fechaInicio = $("#fechaInicioPeriodo").val();
//     const fechaFin = $("#fechaFinalizaPeriodo").val();

//     const datos = {
//         CODIGO_PERIODO: $("#codigoPeriodo").val(),
//         DESCRIPCION_PERIODO: $("#descripcionPeriodo").val(),
//         // Set dates to null if they're empty
//         FECHA_INICIO_PERIODO: fechaInicio ? fechaInicio : null,
//         FECHA_FINALIZA_PERIODO: fechaFin ? fechaFin : null,
//         ESTADO_PERIODO: "A", 
//         ID_PERSONA_INGRESO: ID_PERSONA, 
//         ACCION: accion
//     };
    
//     $.ajax({
//         url: 'http://localhost:3000/periodos',
//         type: 'POST',
//         contentType: 'application/json',
//         data: JSON.stringify(datos),
//         success: function (response) {
//             if (response.mensaje === "") {
//                 // Éxito
//                 $('#periodoModal').modal('hide');
//                 cargarPeriodos('http://localhost:3000/periodos'); 
//                 // Opcional: mostrar mensaje de éxito con toast o notificación
//             } else {
//                 // Mostrar el mensaje de error de la API en el contenedor de errores
//                 showError(response.mensaje);
//             }
//         },
//         error: function (err) {
//             console.error(err);
//             // Mostrar mensaje de error genérico en el contenedor de errores
//             showError("Ocurrió un error en la solicitud. Por favor intente nuevamente.");
//         }
//     });
// });

// // Función para mostrar mensajes de error
// function showError(message) {
//     const errorContainer = document.getElementById('errorMessageContainer');
//     const errorMessageElement = document.getElementById('errorMessage');
    
//     errorMessageElement.textContent = message;
//     errorContainer.classList.remove('d-none');
// }

// // Función para ocultar mensajes de error
// function hideError() {
//     const errorContainer = document.getElementById('errorMessageContainer');
//     errorContainer.classList.add('d-none');
// }


});
</script>


@endsection
