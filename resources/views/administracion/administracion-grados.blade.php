@extends("layouts.header")

@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<div class="header-section">
    <div class="header-title">
        <i class="fas fa-book"></i>
        <span>Administración grados</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>
<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <!-- Barra de búsqueda y filtro de período -->
                <div class="col-md-12 col-lg-12">
                    <div class="row g-2">
                        <div class="col-md-6">
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
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-calendar-alt text-muted"></i>
                                </span>
                                <select id="filtroPeriodo" class="form-select">
                                    <option value="">Seleccione un período...</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaGrados" class="table">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Código Grado</th>
                            <th scope="col">Nombre Grado</th>
                            <th scope="col">Sección</th>
                            <th scope="col">Nivel</th>
                            <th scope="col">Perfil ingreso</th>                         
                            <th scope="col">Acciones</th>
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
<script>
const apiBaseUrl = 'http://localhost:3000/grados';
let currentPage = 1;
let totalPages = 1;
let currentUrl = apiBaseUrl;
let selectedPeriodoId = null; // Variable para almacenar el período seleccionado
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    

$(document).ready(function () {
    // Cargar períodos y grados al inicializar
    cargarPeriodos();
    cargarGrados(apiBaseUrl);
    
    // Event listener para el cambio de período
    $('#filtroPeriodo').on('change', function() {
        selectedPeriodoId = $(this).val();
        console.log('Período seleccionado:', selectedPeriodoId);
        
        // IMPORTANTE: Recargar la tabla para actualizar los enlaces
        cargarGrados(currentUrl, currentPage);
    });
});

// Función para cargar períodos
function cargarPeriodos() {
    $.ajax({
        url: 'http://localhost:3000/periodos/seleccion',
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            populatePeriodosDropdown(data);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar períodos:', error);
        }
    });
}

// Función para llenar el dropdown de períodos
function populatePeriodosDropdown(periodos) {
    const dropdown = $('#filtroPeriodo');
    
    // Limpiar opciones existentes excepto la primera
    dropdown.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(periodos, function(index, periodo) {
        dropdown.append($('<option>', {
            value: periodo.ID_PERIODO_ESCOLAR,
            text: periodo.DESCRIPCION_PERIODO
        }));
    });
    
    // Seleccionar automáticamente el primer período si hay períodos disponibles
    if (periodos.length > 0) {
        selectedPeriodoId = periodos[0].ID_PERIODO_ESCOLAR;
        dropdown.val(selectedPeriodoId);
        
        // Cargar la tabla con el período seleccionado por defecto
        cargarGrados(apiBaseUrl, 1);
    }
}

// Función para cargar grados
function cargarGrados(url, page = 1) {
    let urlFinal = url;
    
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
                    
                    // Construir URL de materias con período seleccionado
                    // CORREGIDO: El orden debe ser grado primero, luego período
                    const materiasUrl = selectedPeriodoId 
                        ? `/administracion-grados/materias/${selectedPeriodoId}/${grado.ID_GRADO}`
                        : '#';
                    
                    // Mejorar el estado del botón
                    const materiasButtonClass = selectedPeriodoId 
                        ? 'btn btn-primary btn-sm me-2' 
                        : 'btn btn-outline-secondary btn-sm me-2 disabled';
                    
                    const materiasAttributes = selectedPeriodoId 
                        ? `href="${materiasUrl}"` 
                        : 'href="#" onclick="return false;" title="Seleccione un período primero"';
                    
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
                                    <a 
                                        ${materiasAttributes}
                                        class="${materiasButtonClass}">
                                        <i class="bi bi-book"></i> Materias
                                    </a>
                                    <a 
                                        href="/administracion-grados/calendario/${grado.CODIGO_GRADO}" 
                                        class="btn btn-secondary btn-sm">
                                        <i class="bi bi-calendar-event"></i> Calendario
                                    </a>
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
// Event listeners para búsqueda
$('#btnBuscar').click(function () {
    const textoBusqueda = $('#inputBusqueda').val().trim();
    const urlBusqueda = textoBusqueda ? `${apiBaseUrl}/busqueda/${encodeURIComponent(textoBusqueda)}` : apiBaseUrl;
    cargarGrados(urlBusqueda, 1);
});

$('#inputBusqueda').on('keypress', function(e) {
    if (e.which === 13) {
        $('#btnBuscar').click();
    }
});

$('#btnLimpiar').on('click', function() {
    $('#inputBusqueda').val('');
    cargarGrados(apiBaseUrl, 1);
});

// Función de paginación
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

if ($('#paginacion').length === 0) {
    $('#tablaGrados').after('<div id="paginacion" class="mt-3"></div>');
}
</script>
@endsection