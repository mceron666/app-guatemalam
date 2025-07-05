<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seleccionar Rol - Colegio Guatemalam</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --verde-oscuro: #0f172a;
            --verde-principal: #1e293b;
            --verde-medio: #334155;
            --verde-claro: #475569;
            --verde-acento: #22c55e;
            --verde-hover: #16a34a;
            --verde-sutil: rgba(34, 197, 94, 0.1);
            --verde-border: rgba(34, 197, 94, 0.2);
            --blanco: #ffffff;
            --blanco-suave: #fafafa;
            --gris-muy-claro: #f8fafc;
            --gris-claro: #f1f5f9;
            --gris-medio: #e2e8f0;
            --gris-texto: #64748b;
            --gris-oscuro: #334155;
            --negro: #0f172a;
            --sombra-sutil: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            --sombra-media: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            --sombra-fuerte: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            --sombra-verde: 0 4px 14px 0 rgba(34, 197, 94, 0.15);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde-principal) 50%, var(--verde-medio) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* Background decorations */
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(34, 197, 94, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 20%, rgba(34, 197, 94, 0.08) 0%, transparent 50%),
                radial-gradient(circle at 40% 80%, rgba(34, 197, 94, 0.06) 0%, transparent 50%);
            opacity: 0.6;
        }

        .selection-container {
            background-color: var(--blanco);
            border-radius: 20px;
            padding: 3rem;
            box-shadow: var(--sombra-fuerte);
            max-width: 800px;
            width: 90%;
            position: relative;
            z-index: 2;
            text-align: center;
        }

        .header-section {
            margin-bottom: 3rem;
        }

        .school-logo {
            width: 80px;
            height: 80px;
            margin-bottom: 1.5rem;
            border-radius: 16px;
            box-shadow: var(--sombra-media);
            transition: transform 0.3s ease;
        }

        .school-logo:hover {
            transform: scale(1.05);
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--gris-oscuro);
            margin-bottom: 0.5rem;
        }

        .welcome-subtitle {
            font-size: 1.1rem;
            color: var(--gris-texto);
            font-weight: 400;
            margin-bottom: 1rem;
        }

        .user-info {
            background-color: var(--gris-muy-claro);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--verde-acento);
        }

        .user-name {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--gris-oscuro);
            margin-bottom: 0.25rem;
        }

        .user-email {
            font-size: 0.9rem;
            color: var(--gris-texto);
        }

        .role-selection {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .role-card {
            background-color: var(--blanco);
            border: 2px solid var(--gris-medio);
            border-radius: 16px;
            padding: 2.5rem 2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
            position: relative;
            overflow: hidden;
        }

        .role-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(34, 197, 94, 0.1), transparent);
            transition: left 0.5s;
        }

        .role-card:hover::before {
            left: 100%;
        }

        .role-card:hover {
            border-color: var(--verde-acento);
            transform: translateY(-8px);
            box-shadow: var(--sombra-verde);
        }

        .role-card.admin:hover {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.05) 0%, rgba(34, 197, 94, 0.02) 100%);
        }

        .role-card.teacher:hover {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.05) 0%, rgba(59, 130, 246, 0.02) 100%);
        }

        .role-icon {
            font-size: 3.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .role-card.admin .role-icon {
            color: var(--verde-acento);
        }

        .role-card.teacher .role-icon {
            color: #3b82f6;
        }

        .role-card:hover .role-icon {
            transform: scale(1.1);
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        .role-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gris-oscuro);
            margin-bottom: 0.75rem;
        }

        .role-description {
            font-size: 1rem;
            color: var(--gris-texto);
            line-height: 1.5;
            margin-bottom: 1.5rem;
        }

        .role-features {
            list-style: none;
            padding: 0;
            text-align: left;
        }

        .role-features li {
            font-size: 0.9rem;
            color: var(--gris-texto);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .role-features li i {
            color: var(--verde-acento);
            font-size: 0.8rem;
        }

        .logout-section {
            border-top: 1px solid var(--gris-medio);
            padding-top: 2rem;
        }

        .btn-logout {
            background-color: transparent;
            color: var(--gris-texto);
            border: 1px solid var(--gris-medio);
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-logout:hover {
            background-color: rgba(239, 68, 68, 0.1);
            border-color: #ef4444;
            color: #ef4444;
            transform: translateY(-2px);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .selection-container {
                padding: 2rem;
                margin: 1rem;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .role-selection {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .role-card {
                padding: 2rem 1.5rem;
            }

            .role-icon {
                font-size: 3rem;
            }

            .role-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 480px) {
            .selection-container {
                padding: 1.5rem;
            }

            .welcome-title {
                font-size: 1.75rem;
            }

            .role-card {
                padding: 1.5rem 1rem;
            }
        }

        /* Loading animation */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--verde-acento);
            border-top: 2px solid transparent;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="selection-container">
        <div class="header-section">
            <img src="/images/image.webp" alt="Logo Colegio Guatemalam" class="school-logo">
            <h1 class="welcome-title">¡Bienvenido!</h1>
            <p class="welcome-subtitle">Selecciona tu rol para continuar</p>
            
            @if(Session::has('usuario'))
            <div class="user-info">
                <div class="user-name">{{ Session::get('usuario')['NOMBRES_PERSONA'] }} {{ Session::get('usuario')['APELLIDOS_PERSONA'] }}</div>
                <div class="user-email">{{ Session::get('usuario')['CORREO_PERSONA'] }}</div>
            </div>
            @endif
        </div>

        <div class="role-selection">
            <!-- Administrador -->
            <a href="#" class="role-card admin" onclick="selectRole('admin')">
                <div class="role-icon">
                    <i class="fas fa-user-shield"></i>
                </div>
                <h3 class="role-title">Administrador</h3>
                <p class="role-description">
                    Acceso completo al sistema de gestión académica y administrativa.
                </p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Gestión de usuarios</li>
                    <li><i class="fas fa-check"></i> Administración de grados</li>
                    <li><i class="fas fa-check"></i> Control de períodos</li>
                    <li><i class="fas fa-check"></i> Reportes y estadísticas</li>
                </ul>
            </a>

            <!-- Profesor -->
            <a href="#" class="role-card teacher" onclick="selectRole('teacher')">
                <div class="role-icon">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <h3 class="role-title">Profesor</h3>
                <p class="role-description">
                    Herramientas especializadas para la gestión de clases y estudiantes.
                </p>
                <ul class="role-features">
                    <li><i class="fas fa-check"></i> Gestión de clases</li>
                    <li><i class="fas fa-check"></i> Registro de notas</li>
                    <li><i class="fas fa-check"></i> Seguimiento de estudiantes</li>
                    <li><i class="fas fa-check"></i> Calendario académico</li>
                </ul>
            </a>
        </div>

        <div class="logout-section">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-logout">
                    <i class="fas fa-sign-out-alt"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        function selectRole(role) {
            // Agregar clase de loading
            const card = event.currentTarget;
            card.classList.add('loading');
            
            // Determinar la ruta según el rol
            let redirectUrl;
            if (role === 'admin') {
                redirectUrl = '/';
            } else if (role === 'teacher') {
                redirectUrl = '/maestro/';
            }
            
            // Pequeño delay para mostrar la animación de loading
            setTimeout(() => {
                window.location.href = redirectUrl;
            }, 500);
        }

        // Prevenir el comportamiento por defecto de los enlaces
        document.querySelectorAll('.role-card').forEach(card => {
            card.addEventListener('click', function(e) {
                e.preventDefault();
            });
        });

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.querySelector('.selection-container');
            container.style.opacity = '0';
            container.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                container.style.transition = 'all 0.6s ease';
                container.style.opacity = '1';
                container.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>