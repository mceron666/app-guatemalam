<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumno</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/alumnos.css" rel="stylesheet">
</head>
<body>
    <!-- Vertical Sidebar -->
    <div id="navbar">
    <!-- Fixed header section -->
    <div id="navbar-header">
        <img src="/images/image.webp" alt="Logo">
    </div>
    
    <!-- Scroll indicators -->
    <div class="scroll-indicator scroll-up" id="scroll-up">
        <i class="bi bi-chevron-up"></i>
    </div>
    <div class="scroll-indicator scroll-down" id="scroll-down">
        <i class="bi bi-chevron-down"></i>
    </div>
    
    <!-- Scrollable menu section -->
    <div id="navbar-menu">
        <!-- Title for the menu -->
        <h6 class="navbar-section-title">Opciones</h6>
        <button id="inicio" onclick="selectNav('inicio'); loadPage('/alumno/')">
            <i class="fas fa-home"></i> <span>Inicio</span>
        </button>
        <button id="notas" onclick="selectNav('notas'); loadPage('/alumno/notas')">
            <i class="fas fa-graduation-cap"></i> <span>Mis notas</span>
        </button>
        <button id="calendario" onclick="selectNav('calendario'); loadPage('/alumno/calendario')">
            <i class="fas fa-calendar-week"></i> <span>Calendario semanal</span>
        </button>
        <button id="pagos" onclick="selectNav('pagos'); loadPage('/alumno/pagos')">
            <i class="fas fa-credit-card"></i> <span>Pagos</span>
        </button>         
    </div>
</div>
    
    <!-- Horizontal Top Navbar -->
    <div id="topnav">
        <div class="left-section">
            <div class="nav-item" id="toggle-sidebar">
                <i class="bi bi-list"></i>
            </div>
            <div class="page-title">
                <span id="current-page-title">Inicio</span>
            </div>
        </div>
        <div class="right-section">
            <div class="nav-item">
                <i class="bi bi-gear"></i>
            </div>
            <div class="user-dropdown" id="userDropdown">
                <div class="user-profile">
                    <div class="user-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <span class="user-name">
                        @if(Session::has('usuario'))
                            {{ Session::get('usuario')['NOMBRES_PERSONA'] }}
                        @else
                            Usuario
                        @endif
                    </span>
                    <i class="bi bi-chevron-down"></i>
                </div>
                <div class="dropdown-menu" id="userMenu">
                    @if(Session::has('usuario'))
                        <div class="user-info">
                            <span class="user-name">{{ Session::get('usuario')['NOMBRES_PERSONA'] }} {{ Session::get('usuario')['APELLIDOS_PERSONA'] }}</span>
                            <span class="user-role">
                                @php
                                    $rol = Session::get('usuario')['PERFIL_PERSONA'];
                                @endphp
                                {{ $rol }}
                            </span>
                            <span class="user-role">
                                @php
                                    $correo = Session::get('usuario')['CORREO_PERSONA'];
                                @endphp
                                {{ $correo }}
                            </span>                                                      
                        </div>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="bi bi-person me-2"></i> Mi Perfil
                        </a>
                        <a href="#" class="dropdown-item">
                            <i class="bi bi-gear me-2"></i> Configuración
                        </a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item logout-btn">
                                <i class="bi bi-box-arrow-right me-2"></i> Cerrar Sesión
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="dropdown-item">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Iniciar Sesión
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Content Area -->
    <div id="content"> 
        @yield("contenido")
    </div>
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    const anioActual = "{{ session('usuario.ANIO_ACTUAL', '') }}";
    
    // Función para actualizar indicadores de scroll
    function updateScrollIndicators() {
        const menu = document.getElementById('navbar-menu');
        const scrollUp = document.getElementById('scroll-up');
        const scrollDown = document.getElementById('scroll-down');
        
        // Show/hide scroll up indicator
        if (menu.scrollTop > 20) {
            scrollUp.classList.add('visible');
        } else {
            scrollUp.classList.remove('visible');
        }
        
        // Show/hide scroll down indicator
        if (menu.scrollHeight - menu.scrollTop - menu.clientHeight > 20) {
            scrollDown.classList.add('visible');
        } else {
            scrollDown.classList.remove('visible');
        }
    }

    function updatePageTitle(route) {
        let title;
        // Evaluación exacta primero
        switch (route) {
            case '/alumno/':
            case '/alumno':
                title = 'Inicio';
                break;
            case '/alumno/notas':
                title = 'Mis Notas';
                break;
            case '/alumno/calendario':
                title = 'Calendario Semanal';
                break;
            case '/alumno/pagos':
                title = 'Pagos';
                break;
            default:
                // Evaluación parcial para rutas con parámetros
                if (route.includes('/alumno/notas')) {
                    title = 'Mis Notas';
                } else if (route.includes('/alumno/calendario')) {
                    title = 'Calendario Semanal';
                } else if (route.includes('/alumno/pagos')) {
                    title = 'Pagos';
                } else if (route.includes('/alumno/')) {
                    title = 'Alumno';
                } else {
                    title = 'Inicio'; // Fallback
                }
        }
        document.getElementById('current-page-title').textContent = title;
        
        // Actualizar selección del menú basado en la ruta
        updateMenuSelection(route);
    }

    function updateMenuSelection(route) {
        // Limpiar todas las selecciones actuales
        document.querySelectorAll('#navbar button').forEach(btn => btn.classList.remove('selected'));
        
        let selectedMenuId = null;
        
        // Determinar qué elemento del menú debe estar seleccionado basado en la ruta
        if (route === '/alumno/' || route === '/alumno') {
            selectedMenuId = 'inicio';
        } else if (route === '/alumno/notas' || route.includes('/alumno/notas')) {
            selectedMenuId = 'notas';
        } else if (route === '/alumno/calendario' || route.includes('/alumno/calendario')) {
            selectedMenuId = 'calendario';
        } else if (route === '/alumno/pagos' || route.includes('/alumno/pagos')) {
            selectedMenuId = 'pagos';
        }
        
        // Aplicar la selección si se encontró una coincidencia
        if (selectedMenuId) {
            const menuElement = document.getElementById(selectedMenuId);
            if (menuElement) {
                menuElement.classList.add('selected');
                
                // Scroll the selected item into view
                menuElement.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        }
    }

    // Modificar la función selectNav para que solo maneje el scroll, no la selección
    function selectNav(id) {
        // Solo hacer scroll al elemento, la selección se maneja automáticamente por la ruta
        const selectedButton = document.getElementById(id);
        if (selectedButton) {
            selectedButton.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    // Modificar la función loadPage para que actualice la selección automáticamente
    function loadPage(route) {
        axios.get(route, { 
            headers: { 
                "X-Requested-With": "XMLHttpRequest" 
            } 
        })
        .then(response => {
            document.getElementById('content').innerHTML = response.data;
            window.history.pushState({}, '', route);
            
            // Execute any scripts in the loaded content
            const scripts = document.getElementById('content').getElementsByTagName('script');
            for (let i = 0; i < scripts.length; i++) {
                eval(scripts[i].innerText);
            }
            
            // Update page title and menu selection based on route
            updatePageTitle(route);
            
            // Trigger a custom event to notify that content has been loaded
            document.dispatchEvent(new CustomEvent('contentLoaded', { detail: { route } }));
        })
        .catch(error => {
            console.error('Error al cargar la página:', error);
        });
    }

    // Modificar el event listener del popstate para actualizar la selección
    window.onpopstate = () => {
        const currentPath = window.location.pathname;
        loadPage(currentPath);
    };

    // Modificar la inicialización para establecer la selección correcta al cargar
    document.addEventListener('DOMContentLoaded', () => {
        // Cargar la página actual y establecer la selección correcta
        const currentPath = window.location.pathname;
        loadPage(currentPath);
        
        // Toggle sidebar functionality
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });
        
        const menu = document.getElementById('navbar-menu');
        const scrollUp = document.getElementById('scroll-up');
        const scrollDown = document.getElementById('scroll-down');
        
        // Initialize scroll indicators
        updateScrollIndicators();
        
        // Update indicators when scrolling
        menu.addEventListener('scroll', updateScrollIndicators);
        
        // Scroll up when clicking the up indicator
        scrollUp.addEventListener('click', function() {
            menu.scrollBy({ top: -100, behavior: 'smooth' });
        });
        
        // Scroll down when clicking the down indicator
        scrollDown.addEventListener('click', function() {
            menu.scrollBy({ top: 100, behavior: 'smooth' });
        });
        
        // User dropdown functionality - CORREGIDO
        const userDropdown = document.getElementById('userDropdown');
        const userMenu = document.getElementById('userMenu');
        
        userDropdown.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            userMenu.classList.toggle('show');
        });
        
        // Prevenir que el menú se cierre al hacer clic dentro de él
        userMenu.addEventListener('click', function(e) {
            e.stopPropagation();
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userDropdown.contains(e.target)) {
                userMenu.classList.remove('show');
            }
        });
        
        // Manejar el envío del formulario de logout
        const logoutForm = userMenu.querySelector('form');
        if (logoutForm) {
            logoutForm.addEventListener('submit', function(e) {
                // Permitir que el formulario se envíe normalmente
                userMenu.classList.remove('show');
            });
        }
    });
    </script>
</body>
</html>