@extends("layouts.header")

@section("contenido")
<style>
/* Dashboard Statistics Styles */
.stats-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    min-height: calc(100vh - 200px);
    padding: 2rem 0;
}

.stats-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    padding: 2rem;
    margin-bottom: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 25px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

.stat-item {
    background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    color: white;
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    margin-bottom: 1rem;
    position: relative;
    overflow: hidden;
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 50%);
    opacity: 0.8;
}

.stat-item.financial {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
}

.stat-item.warning {
    background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
}

.stat-item.danger {
    background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
}

.stat-number {
    font-size: 2.5rem;
    font-weight: 800;
    margin-bottom: 0.5rem;
    position: relative;
    z-index: 1;
}

.stat-label {
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    opacity: 0.9;
    position: relative;
    z-index: 1;
}

.section-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.section-title i {
    color: #3b82f6;
    font-size: 1.25rem;
}

/* Updated event styling with color coding for T=Green, A=Red, M=Blue */
.event-item {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.75rem;
    border-left: 4px solid #3b82f6;
}

.event-item.todos {
    border-left-color: #10b981;
    background: #f0fdf4;
    border-color: #bbf7d0;
}

.event-item.alumnos {
    border-left-color: #ef4444;
    background: #fef2f2;
    border-color: #fecaca;
}

.event-item.maestros {
    border-left-color: #3b82f6;
    background: #eff6ff;
    border-color: #dbeafe;
}

.event-date {
    font-size: 0.875rem;
    color: #6b7280;
    font-weight: 600;
}

.event-name {
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin: 0.25rem 0;
}

.event-description {
    font-size: 0.875rem;
    color: #4b5563;
}

.role-badge {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.role-badge.admin {
    background: #fef3c7;
    color: #92400e;
}

.role-badge.teacher {
    background: #dbeafe;
    color: #1e40af;
}

.role-badge.student {
    background: #d1fae5;
    color: #065f46;
}

/* Added chart container styles */
.chart-container {
    position: relative;
    height: 300px;
    margin: 1rem 0;
}

.chart-wrapper {
    background: #f8fafc;
    border-radius: 12px;
    padding: 1.5rem;
    margin-top: 1rem;
}

.loading-spinner {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 200px;
}

.spinner {
    width: 40px;
    height: 40px;
    border: 4px solid #e2e8f0;
    border-top: 4px solid #3b82f6;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.error-message {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
    padding: 1rem;
    border-radius: 8px;
    text-align: center;
    margin: 1rem 0;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .stats-container {
        padding: 1rem 0;
    }
    
    .stats-card {
        padding: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .stat-number {
        font-size: 2rem;
    }
    
    .chart-container {
        height: 250px;
    }
}
</style>

<!-- Added Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="header-section">
    <div class="header-title">
        <i class="fas fa-chart-bar"></i>
        <span>Gestión educativa Colegio Guatemalam</span>
    </div>
    <div class="header-decoration-1"></div>
    <div class="header-decoration-2"></div>
</div>

<div class="stats-container">
    <div class="container-fluid">
        <div id="eventsSection" class="stats-card">
            <h2 class="section-title">
                <i class="fas fa-calendar-alt"></i>
                Próximos Eventos
            </h2>
            <div id="eventsContent">
                <!-- Dynamic content will be inserted here -->
            </div>
        </div>        
        <!-- Loading State -->
        <div id="loadingState" class="loading-spinner">
            <div class="spinner"></div>
        </div>

        <!-- Error State -->
        <div id="errorState" class="error-message d-none">
            <i class="fas fa-exclamation-triangle"></i>
            Error al cargar las estadísticas. Por favor, intente nuevamente.
        </div>

        <!-- Main Content -->
        <div id="mainContent" class="d-none">
            <!-- Personal Statistics (Visible to P and G roles) -->
            <div id="personalStats" class="stats-card d-none">
                <h2 class="section-title">
                    <i class="fas fa-users"></i>
                    Personal de la Institución
                </h2>
                <div class="row" id="personalStatsContent">
                    <!-- Dynamic content will be inserted here -->
                </div>
                <!-- Added chart container for personnel distribution -->
                <div class="chart-wrapper">
                    <h4 class="text-center mb-3">Distribución del Personal</h4>
                    <div class="chart-container">
                        <canvas id="personalChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Financial Statistics (Visible to P and G roles) -->
            <div id="financialStats" class="stats-card d-none">
                <h2 class="section-title">
                    <i class="fas fa-dollar-sign"></i>
                    Estado Financiero
                </h2>
                <div class="row" id="financialStatsContent">
                    <!-- Dynamic content will be inserted here -->
                </div>
                <!-- Added two separate chart containers for balance amounts and student distribution -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="chart-wrapper">
                            <h4 class="text-center mb-3">Montos Financieros</h4>
                            <div class="chart-container">
                                <canvas id="financialChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="chart-wrapper">
                            <h4 class="text-center mb-3">Distribución de Alumnos</h4>
                            <div class="chart-container">
                                <canvas id="studentsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Events Section (Visible to all roles) -->

            <!-- User Role Info -->
            <div class="stats-card">
                <h2 class="section-title">
                    <i class="fas fa-user"></i>
                    Mi Información
                </h2>
                <div class="text-center">
                    <span id="userRoleBadge" class="role-badge"></span>
                    <p class="mt-3 text-muted">
                        <span id="userRoleDescription"></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Get user role from session
const USER_ROLE = @json(Session::get('usuario')['ROL_PERSONA'] ?? 'A');

// Role descriptions
const roleDescriptions = {
    'A': { name: 'Estudiante', description: 'Acceso a información académica y eventos', class: 'student' },
    'M': { name: 'Maestro', description: 'Acceso a información académica y de enseñanza', class: 'teacher' },
    'P': { name: 'Maestro Administrador', description: 'Acceso completo a estadísticas institucionales', class: 'admin' },
    'G': { name: 'Administrador', description: 'Acceso total a todas las estadísticas del sistema', class: 'admin' }
};

let personalChart = null;
let financialChart = null;
let studentsChart = null;

$(document).ready(function() {
    loadStatistics();
    setupUserRoleInfo();
});

function setupUserRoleInfo() {
    const roleInfo = roleDescriptions[USER_ROLE] || roleDescriptions['A'];
    $('#userRoleBadge').text(roleInfo.name).addClass(roleInfo.class);
    $('#userRoleDescription').text(roleInfo.description);
}

function loadStatistics() {
    $.ajax({
        url: 'http://localhost:3000/institucion/estadisticas',
        type: 'GET',
        success: function(response) {
            hideLoading();
            displayStatistics(response);
        },
        error: function(xhr) {
            hideLoading();
            showError();
            console.error('Error loading statistics:', xhr);
        }
    });
}

function hideLoading() {
    $('#loadingState').addClass('d-none');
    $('#mainContent').removeClass('d-none');
}

function showError() {
    $('#loadingState').addClass('d-none');
    $('#errorState').removeClass('d-none');
}

function displayStatistics(data) {
    // Show sections based on user role
    if (USER_ROLE === 'P' || USER_ROLE === 'G') {
        displayPersonalStats(data.personal);
        displayFinancialStats(data.solvencia);
        $('#personalStats').removeClass('d-none');
        $('#financialStats').removeClass('d-none');
    }
    
    // Events are visible to all roles
    displayEvents(data.eventos);
}

function displayPersonalStats(personalData) {
    const container = $('#personalStatsContent');
    container.empty();
    
    const roleNames = {
        'A': 'Estudiantes',
        'M': 'Maestros', 
        'P': 'Maestros Admin.',
        'G': 'Administradores'
    };
    
    const chartData = [];
    const chartLabels = [];
    const chartColors = ['#ef4444', '#3b82f6', '#f59e0b', '#10b981'];
    
    personalData.forEach((item, index) => {
        const roleName = roleNames[item.ROL_PERSONA] || 'Desconocido';
        chartData.push(item.TOTAL);
        chartLabels.push(roleName);
        
        const html = `
            <div class="col-md-3 col-sm-6">
                <div class="stat-item">
                    <div class="stat-number">${item.TOTAL}</div>
                    <div class="stat-label">${roleName}</div>
                </div>
            </div>
        `;
        container.append(html);
    });
    
    // Create pie chart
    createPersonalChart(chartLabels, chartData, chartColors);
}

function displayFinancialStats(solvenciaData) {
    const container = $('#financialStatsContent');
    container.empty();
    
    const stats = [
        {
            value: formatCurrency(Math.abs(solvenciaData.PAGADO)),
            label: 'Total Pagado',
            class: 'financial'
        },
        {
            value: formatCurrency(Math.abs(solvenciaData.DEUDA)),
            label: 'Total Deuda',
            class: 'danger'
        }
    ];
    
    stats.forEach(stat => {
        const html = `
            <div class="col-md-6 col-sm-6">
                <div class="stat-item ${stat.class}">
                    <div class="stat-number">${stat.value}</div>
                    <div class="stat-label">${stat.label}</div>
                </div>
            </div>
        `;
        container.append(html);
    });
    
    createFinancialChart(solvenciaData);
    createStudentsChart(solvenciaData);
}

function displayEvents(eventsData) {
    const container = $('#eventsContent');
    container.empty();
    
    if (!eventsData || eventsData.length === 0) {
        container.html(`
            <div class="text-center text-muted py-4">
                <i class="fas fa-calendar-times fa-3x mb-3"></i>
                <p>No hay eventos próximos programados</p>
            </div>
        `);
        return;
    }
    
    eventsData.forEach(evento => {
        const fechaEvento = new Date(evento.FECHA_EVENTO);
        const horaEvento = evento.HORA_EVENTO ? 
            new Date(evento.HORA_EVENTO).toLocaleTimeString('es-ES', { 
                hour: '2-digit', 
                minute: '2-digit' 
            }) : 'Sin hora especificada';
        
        const aplicaParaText = {
            'T': 'Todos',
            'A': 'Alumnos',
            'M': 'Maestros'
        }[evento.APLICA_PARA] || 'Desconocido';
        
        // Determine event class based on APLICA_PARA
        const eventClass = {
            'T': 'todos',
            'A': 'alumnos', 
            'M': 'maestros'
        }[evento.APLICA_PARA] || '';
        
        const html = `
            <div class="event-item ${eventClass}">
                <div class="event-date">
                    <i class="fas fa-calendar"></i>
                    ${fechaEvento.toLocaleDateString('es-ES', { 
                        weekday: 'long', 
                        year: 'numeric', 
                        month: 'long', 
                        day: 'numeric' 
                    })} - ${horaEvento}
                </div>
                <div class="event-name">${evento.NOMBRE_EVENTO}</div>
                <div class="event-description">
                    ${evento.DESCRIPCION_EVENTO || 'Sin descripción'}
                </div>
                <div class="mt-2">
                    <small class="text-muted">
                        <i class="fas fa-users"></i> Aplica para: ${aplicaParaText}
                        ${evento.SE_SUSPENDEN_CLASES === 'Y' ? 
                            ' <span class="badge bg-warning text-dark ms-2"><i class="fas fa-ban"></i> Se suspenden clases</span>' : 
                            ''
                        }
                    </small>
                </div>
            </div>
        `;
        container.append(html);
    });
}

function createPersonalChart(labels, data, colors) {
    const ctx = document.getElementById('personalChart').getContext('2d');
    
    if (personalChart) {
        personalChart.destroy();
    }
    
    personalChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: colors,
                borderWidth: 2,
                borderColor: '#ffffff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        font: {
                            size: 12,
                            weight: '600'
                        }
                    }
                }
            }
        }
    });
}

function createFinancialChart(solvenciaData) {
    const ctx = document.getElementById('financialChart').getContext('2d');
    
    if (financialChart) {
        financialChart.destroy();
    }
    
    financialChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Total Pagado', 'Total Deuda'],
            datasets: [{
                label: 'Monto',
                data: [
                    Math.abs(solvenciaData.PAGADO),
                    Math.abs(solvenciaData.DEUDA)
                ],
                backgroundColor: ['#10b981', '#ef4444'],
                borderColor: ['#059669', '#dc2626'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return formatCurrency(value);
                        }
                    }
                }
            }
        }
    });
}

function createStudentsChart(solvenciaData) {
    const ctx = document.getElementById('studentsChart').getContext('2d');
    
    if (studentsChart) {
        studentsChart.destroy();
    }
    
    studentsChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Alumnos Solventes', 'Alumnos con Deuda'],
            datasets: [{
                data: [
                    solvenciaData.ALUMNOS_SOLVENTES,
                    solvenciaData.ALUMNOS_CON_DEUDA
                ],
                backgroundColor: ['#10b981', '#f59e0b'],
                borderColor: ['#059669', '#d97706'],
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true
                    }
                }
            }
        }
    });
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('es-GT', {
        style: 'currency',
        currency: 'GTQ',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(amount);
}
</script>
@endsection
