@extends("layouts.header")

@section("contenido")

<link href="/css/modal.css" rel="stylesheet">

<div class="header-section">
    <div class="header-title">
        <i class="fa fa-users" aria-hidden="true"></i>
        <span>Administrar alumnos</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow w-100">
        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <!-- Barra de búsqueda y filtros -->
                <div class="col-md-12 col-lg-12">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-search text-muted"></i>
                                </span>
                                <input type="text" id="inputBusqueda" class="form-control border-start-0" 
                                       placeholder="Buscar por nombre completo..." aria-label="Buscar alumno">
                                <button id="btnBuscar" class="btn btn-success px-3">
                                    Buscar
                                </button>
                                <button id="btnLimpiar" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle me-1"></i>Limpiar
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-book text-muted"></i>
                                </span>
                                <select id="filtroGrado" class="form-select">
                                    <option value="">Todos los grados</option>
                                    <!-- Se llenará dinámicamente -->
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-cash text-muted"></i>
                                </span>
                                <select id="filtroSolvencia" class="form-select">
                                    <option value="">Todos</option>
                                    <option value="Y">Solvente</option>
                                    <option value="N">Insolvente</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table id="tablaAlumnos" class="table">
                    <thead class="bg-success text-white text-center">
                        <tr>
                            <th scope="col">Perfil</th>
                            <th scope="col">Nombre Completo</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Grado</th>
                            <th scope="col">Sección</th>
                            <th scope="col">Diferencia Solvencia</th>
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
const apiBaseUrl = 'http://localhost:3000/alumnos-grado/lista';
const gradosApiUrl = 'http://localhost:3000/grados';
let currentPage = 1;
let totalPages = 1;
let selectedGradoId = null;
let selectedSolvencia = null;
let currentSearchTerm = '';

const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    

$(document).ready(function () {
    // Cargar grados y alumnos al inicializar
    cargarGrados();
    cargarAlumnos();
    
    // Event listeners para los filtros
    $('#filtroGrado').on('change', function() {
        selectedGradoId = $(this).val();
        console.log('Grado seleccionado:', selectedGradoId);
        cargarAlumnos(1);
    });

    $('#filtroSolvencia').on('change', function() {
        selectedSolvencia = $(this).val();
        console.log('Solvencia seleccionada:', selectedSolvencia);
        cargarAlumnos(1);
    });
});

// Función para cargar grados
function cargarGrados() {
    $.ajax({
        url: gradosApiUrl,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            populateGradosDropdown(response.data);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar grados:', error);
        }
    });
}

// Función para llenar el dropdown de grados
function populateGradosDropdown(grados) {
    const dropdown = $('#filtroGrado');
    
    // Limpiar opciones existentes excepto la primera
    dropdown.find('option:not(:first)').remove();
    
    // Agregar nuevas opciones
    $.each(grados, function(index, grado) {
        dropdown.append($('<option>', {
            value: grado.ID_GRADO,
            text: grado.NOMBRE_GRADO
        }));
    });
}

// Función para cargar alumnos
function cargarAlumnos(page = 1) {
    const requestData = {
        ID_GRADO: selectedGradoId || null,
        NOMBRE_COMPLETO: currentSearchTerm || "",
        CORREO_PERSONA: "",
        SOLVENCIA: selectedSolvencia || ""
    };

    $.ajax({
        url: apiBaseUrl,
        type: 'POST',
        dataType: 'json',
        contentType: 'application/json',
        data: JSON.stringify(requestData),
        cache: false,
        success: function (response) {
            const data = response.data;
            const pagination = response.pagination;
            currentPage = pagination.currentPage;
            totalPages = pagination.totalPages;
            
            const tbody = $('#tablaAlumnos tbody');
            tbody.empty(); 
            
            if (data.length === 0) {
                tbody.append('<tr><td colspan="7" class="text-center">No se encontraron alumnos</td></tr>');
            } else {
                data.forEach(alumno => {
                    // Determinar el color de la diferencia de solvencia
                    let solvenciaClass = '';
                    let solvenciaStyle = '';
                    if (alumno.DIFERENCIA_SOLVENCIA < 0) {
                        solvenciaClass = 'text-danger fw-bold';
                        solvenciaStyle = 'color: red !important;';
                    } else {
                        solvenciaClass = 'text-success fw-bold';
                        solvenciaStyle = 'color: green !important;';
                    }
                    
                    // Formatear la diferencia de solvencia como moneda
                    const diferenciaSolvencia = new Intl.NumberFormat('es-GT', {
                        style: 'currency',
                        currency: 'GTQ'
                    }).format(alumno.DIFERENCIA_SOLVENCIA);
                    
                    // Determinar la clase del badge para la sección
                    let seccionClase = '';
                    switch (alumno.SECCION_GRADO) {
                        case 'A':
                            seccionClase = 'badge bg-primary';
                            break;
                        case 'B':
                            seccionClase = 'badge bg-danger';
                            break;
                        case 'C':
                            seccionClase = 'badge bg-success';
                            break;
                        default:
                            seccionClase = 'badge bg-secondary';
                            break;
                    }
                    
                    const fila = `
                        <tr>
                            <td>${alumno.PERFIL_PERSONA}</td>
                            <td class="text-start">${alumno.NOMBRE_COMPLETO}</td>
                            <td class="text-start">${alumno.CORREO_PERSONA}</td>
                            <td class="text-start">${alumno.NOMBRE_GRADO}</td>
                            <td>
                                <span class="${seccionClase}" style="padding: 5px 10px; font-size: 14px;">
                                    ${alumno.SECCION_GRADO}
                                </span>
                            </td>
                            <td class="${solvenciaClass}" style="${solvenciaStyle}">
                                ${diferenciaSolvencia}
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center">
                                    <a 
                                        href="/pagos/${alumno.ID_ALUMNO}"
                                        class="btn btn-primary btn-sm me-2">
                                        <i class="bi bi-credit-card"></i> Control de pagos
                                    </a>
                                    <a 
                                        href="/notas-alumnos/${alumno.ID_ALUMNO}"
                                        class="btn btn-primary btn-sm">
                                        <i class="bi bi-credit-card"></i> Notas escolares
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
            console.error('Error al cargar los alumnos:', error);
            $('#tablaAlumnos tbody').html('<tr><td colspan="7" class="text-center">Error al cargar datos</td></tr>');
        }
    });
}

// Event listeners para búsqueda
$('#btnBuscar').click(function () {
    currentSearchTerm = $('#inputBusqueda').val().trim();
    cargarAlumnos(1);
});

$('#inputBusqueda').on('keypress', function(e) {
    if (e.which === 13) {
        $('#btnBuscar').click();
    }
});

$('#btnLimpiar').on('click', function() {
    $('#inputBusqueda').val('');
    currentSearchTerm = '';
    cargarAlumnos(1);
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
            cargarAlumnos(page);
        }
    });
}

if ($('#paginacion').length === 0) {
    $('#tablaAlumnos').after('<div id="paginacion" class="mt-3"></div>');
}
</script>

@endsection