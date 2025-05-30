<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sitio Dinámico</title>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="/css/app.css" rel="stylesheet">
    <style>
        .period-selector-container {
            margin: 15px 10px 20px 10px;
            padding: 12px;
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .period-selector-label {
            color: #e8f5e9;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .period-selector select {
            width: 100%;
            background-color: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 8px;
            padding: 8px 12px;
            color: #2e7d32;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .period-selector select:focus {
            outline: none;
            border-color: #00A12B;
            box-shadow: 0 0 0 2px rgba(0, 161, 43, 0.3);
            background-color: white;
        }
        
        .period-selector select option {
            color: #2e7d32;
            background-color: white;
            padding: 8px;
        }
        
        /* Responsive adjustments for collapsed sidebar */
        body.sidebar-collapsed .period-selector-container {
            display: none;
        }
        
        @media (max-width: 768px) {
            .period-selector-container {
                display: none;
            }
        }
    </style>
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
        <div class="period-selector-container">
            <label class="period-selector-label" for="period-select">
                <i class="fas fa-calendar-check"></i> Período Activo
            </label>
            <div class="period-selector">
                <select id="period-select" onchange="onPeriodChange()">
                    <option value="">Cargando períodos...</option>
                </select>
            </div>
        </div>         
        <h6 class="navbar-section-title">Datos generales</h6>

        <button id="inicio" onclick="selectNav('inicio'); loadPage('/')">
            <i class="fas fa-home"></i> <span>Inicio</span>
        </button>
        <button id="periodos" onclick="selectNav('periodos'); loadPage('/periodos')">
            <i class="fas fa-calendar-alt"></i> <span>Períodos Escolares</span>
        </button>
        <button id="carreras" onclick="selectNav('carreras'); loadPage('/carreras')">
            <i class="bi bi-mortarboard"></i> <span>Carreras</span>
        </button>        
        <button id="usuarios" onclick="selectNav('usuarios'); loadPage('/usuarios')">
            <i class="fas fa-users"></i> <span>Usuarios</span>
        </button>
        <button id="materias" onclick="selectNav('materias'); loadPage('/materias')">
            <i class="fas fa-book"></i> <span>Materias</span>
        </button>
        <button id="grados" onclick="selectNav('grados'); loadPage('/grados')">
            <i class="fas fa-graduation-cap"></i> <span>Grados</span>
        </button>      
        <!-- Add more menu items to demonstrate scrolling -->
        <h6 class="navbar-section-title">Administración @php
        $anio = Session::get('usuario')['ANIO_ACTUAL']; @endphp {{ $anio }}</h6>
        
        <!-- Period Selector -->
        <button id="administracion-grados" onclick="selectNav('administracion-grados'); loadPage('/administracion-grados')">
            <i class="fas fa-book-reader"></i> <span>Administrar grados</span>
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
    
    // Global variable to store periods
    let schoolPeriods = [];
    
    // Function to get the selected period ID (can be called from other Blade files)
    function getSelectedPeriodId() {
        const selectedValue = document.getElementById('period-select').value;
        return selectedValue || localStorage.getItem('selectedPeriodId') || null;
    }
    
    // Function to get the selected period object
    function getSelectedPeriod() {
        const selectedId = getSelectedPeriodId();
        if (!selectedId) return null;
        
        return schoolPeriods.find(period => period.ID_PERIODO_ESCOLAR == selectedId) || null;
    }
    
    // Function to set the selected period programmatically
    function setSelectedPeriod(periodId) {
        const select = document.getElementById('period-select');
        select.value = periodId;
        localStorage.setItem('selectedPeriodId', periodId);
        
        // Trigger change event
        const event = new Event('change');
        select.dispatchEvent(event);
    }
    
    // Function to load school periods from API
    function loadSchoolPeriods() {
        axios.get('http://localhost:3000/periodos/seleccion')
            .then(response => {
                schoolPeriods = response.data;
                populatePeriodSelector(schoolPeriods);
            })
            .catch(error => {
                console.error('Error al cargar períodos escolares:', error);
                const select = document.getElementById('period-select');
                select.innerHTML = '<option value="">Error al cargar períodos</option>';
            });
    }
    
    // Function to populate the period selector
    function populatePeriodSelector(periods) {
        const select = document.getElementById('period-select');
        select.innerHTML = '<option value="">Seleccionar período...</option>';
        
        periods.forEach(period => {
            const option = document.createElement('option');
            option.value = period.ID_PERIODO_ESCOLAR;
            option.textContent = period.DESCRIPCION_PERIODO;
            select.appendChild(option);
        });
        
        // Auto-select the first period if no period is saved
        const savedPeriodId = localStorage.getItem('selectedPeriodId');
        if (savedPeriodId && periods.find(p => p.ID_PERIODO_ESCOLAR == savedPeriodId)) {
            select.value = savedPeriodId;
        } else if (periods.length > 0) {
            // Select the first period by default
            const firstPeriod = periods[0];
            select.value = firstPeriod.ID_PERIODO_ESCOLAR;
            localStorage.setItem('selectedPeriodId', firstPeriod.ID_PERIODO_ESCOLAR);
            
            // Trigger the change event for the auto-selected period
            setTimeout(() => {
                $(document).trigger('periodoSeleccionado', [firstPeriod.ID_PERIODO_ESCOLAR, firstPeriod]);
            }, 100);
        }
    }
    
    // Function called when period selection changes
    function onPeriodChange() {
        const selectedId = getSelectedPeriodId();
        if (selectedId) {
            localStorage.setItem('selectedPeriodId', selectedId);
            $(document).trigger('periodoSeleccionado', [selectedId, getSelectedPeriod()]);
        } else {
            localStorage.removeItem('selectedPeriodId');
        }
    }
    
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
            
            // Update page title in top navbar
            updatePageTitle(route);
            
            // Trigger a custom event to notify that content has been loaded
            document.dispatchEvent(new CustomEvent('contentLoaded', { detail: { route } }));
        })
        .catch(error => {
            console.error('Error al cargar la página:', error);
        });
    }

    function selectNav(id) {
        document.querySelectorAll('#navbar button').forEach(btn => btn.classList.remove('selected'));
        document.getElementById(id).classList.add('selected');
        
        // Scroll the selected item into view
        const selectedButton = document.getElementById(id);
        selectedButton.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
    
    function updatePageTitle(route) {
    let title;

    // Evaluación exacta primero
    switch (route) {
        case '/':
            title = 'Inicio';
            break;
        case '/materias':
            title = 'Materias Escolares';
            break;
        case '/periodos':
            title = 'Períodos Escolares';
            break;
        case '/carreras':
            title = 'Carreras Estudiantiles';
            break;
        case '/usuarios':
            title = 'Usuarios';
            break;
        case '/grados':
            title = 'Grados y Carreras';
            break;
        case '/administracion-grados':
            title = 'Administración de grados ' + anioActual;
            break;
        case '/agregar-usuario':
            title = 'Usuarios - Agregar';
            break;
        case '/agregar-periodo':
            title = 'Períodos - Agregar';
            break;
        default:
            // Evaluación parcial para rutas con parámetros
            if (route.includes('/modificar-usuario')) {
                title = 'Usuarios - Modificar';
            } else if (route.includes('/modificar-periodo')) {
                title = 'Períodos - Modificar';
            } else {
                title = 'Inicio'; // Fallback
            }
    }
    document.getElementById('current-page-title').textContent = title;
}

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

    window.onpopstate = () => {
        const currentPath = window.location.pathname;
        loadPage(currentPath);
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Load school periods when page loads
        loadSchoolPeriods();
        
        loadPage(window.location.pathname);
        
        // Toggle sidebar functionality
        document.getElementById('toggle-sidebar').addEventListener('click', function() {
            document.body.classList.toggle('sidebar-collapsed');
        });
        
        // Navbar scroll functionality
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
        
        // User dropdown functionality
        const userDropdown = document.getElementById('userDropdown');
        const userMenu = document.getElementById('userMenu');
        
        userDropdown.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenu.classList.toggle('show');
        });
        
        // Close dropdown when clicking outside
        document.addEventListener('click', function() {
            userMenu.classList.remove('show');
        });
    });
    </script>
</body>
</html>