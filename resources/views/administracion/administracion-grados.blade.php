@extends("layouts.header")

@section("contenido")
<link href="/css/modal.css" rel="stylesheet">
<script src="/js/pagineo.js"></script>
<div id="header-periodos" class="mb-4" style="position: relative; width: 100%; height: 200px; overflow: hidden;">
    <img src="/images/guatemala.jpg" alt="Header" style="width: 100%; height: 200px; object-fit: cover;">
    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 60%, white 100%);"></div>
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: white; font-size: 34px; font-weight: bold; text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.8);"> 
    <i class="fas fa-book"></i> Administración grados  <span id="header-periodo-codigo">Cargando...</span>
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
<script>
const apiBaseUrl = 'http://localhost:3000/grados'; // URL base de la API
const periodoId = getSelectedPeriodId();
let currentPage = 1;
let totalPages = 1;
let currentUrl = apiBaseUrl;
const ID_PERSONA = {{ Session::get('usuario')['ID_PERSONA'] ?? 'null' }};    
// Función para actualizar el código del período en el encabezado
function updateHeaderPeriodCode() {
    const headerPeriodElement = document.getElementById('header-periodo-codigo');
    if (headerPeriodElement) {
        const selectedPeriod = getSelectedPeriod();
        if (selectedPeriod) {
            headerPeriodElement.textContent = selectedPeriod.CODIGO_PERIODO;
        } else {
            headerPeriodElement.textContent = "No seleccionado";
        }
    }
}

// Actualizar el código del período cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    // Actualizar inicialmente (después de cargar los períodos)
    setTimeout(updateHeaderPeriodCode, 500);
});

document.addEventListener('contentLoaded', function() {
    updateHeaderPeriodCode();
});
$(document).ready(function () {
    // Fetch careers when page loads
    fetchCareers();
    $(document).on('periodoSeleccionado', function(event, periodoId, periodoObj) {
    updateHeaderPeriodCode();
});

    
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
    <a 
        href="/administracion-grados/materias/${grado.CODIGO_GRADO}" 
        class="btn btn-primary btn-sm me-2">
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
</script>
@endsection

