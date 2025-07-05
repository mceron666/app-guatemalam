<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Colegio Guatemalam</title>
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
            overflow: hidden;
            background-color: var(--blanco);
        }

        .login-wrapper {
            display: flex;
            height: 100vh;
        }

        /* Left side - Background Image */
        .background-side {
            flex: 1;
            background-image: url('/images/atitlan.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .background-side::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, 
                rgba(15, 23, 42, 0.7) 0%, 
                rgba(30, 41, 59, 0.6) 30%, 
                rgba(51, 65, 85, 0.5) 70%, 
                rgba(34, 197, 94, 0.3) 100%);
            z-index: 1;
        }

        .background-content {
            position: relative;
            z-index: 2;
            text-align: center;
            color: white;
            max-width: 600px;
            padding: 2rem;
        }

        .welcome-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            text-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            line-height: 1.1;
        }

        .welcome-subtitle {
            font-size: 1.3rem;
            opacity: 0.95;
            font-weight: 300;
            line-height: 1.6;
            margin-bottom: 2rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .feature-highlight {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .feature-icon {
            font-size: 3rem;
            color: var(--verde-acento);
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 10px rgba(34, 197, 94, 0.5));
        }

        /* Right side - Login Form (Larger) */
        .login-side {
            flex: 0 0 650px;
            background-color: var(--blanco);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            box-shadow: -10px 0 30px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .login-container {
            width: 100%;
            max-width: 480px;
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

.school-logo {
    width: 240px;
    height: 240px;
    margin-bottom: 1rem;
    border-radius: 50%;
    border: 3px solid var(--verde-oscuro);
    box-shadow: var(--sombra-media);
    transition: transform 0.3s ease;
}

        .school-logo:hover {
            transform: scale(1.05);
        }

        .school-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gris-oscuro);
            margin-bottom: 0.5rem;
        }

        .school-tagline {
            font-size: 0.9rem;
            color: var(--gris-texto);
            font-weight: 400;
        }

        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .login-title {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--gris-oscuro);
            margin-bottom: 0.5rem;
        }

        .login-subtitle {
            color: var(--gris-texto);
            font-size: 1.1rem;
            font-weight: 400;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            display: block;
            font-size: 1rem;
            font-weight: 600;
            color: var(--gris-oscuro);
            margin-bottom: 0.75rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 1.25rem 1.25rem 1.25rem 3.5rem;
            border: 2px solid var(--gris-medio);
            border-radius: 12px;
            font-size: 1.1rem;
            background-color: var(--blanco);
            color: var(--gris-oscuro);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--verde-acento);
            box-shadow: 0 0 0 4px var(--verde-sutil);
            transform: translateY(-2px);
        }

        .form-control::placeholder {
            color: var(--gris-texto);
            opacity: 0.7;
        }

        .input-icon {
            position: absolute;
            left: 1.25rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gris-texto);
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }

        .form-control:focus + .input-icon {
            color: var(--verde-acento);
        }

        .btn-login {
            width: 100%;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(135deg, var(--verde-acento) 0%, var(--verde-hover) 100%);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 700;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn-login::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-login:hover::before {
            left: 100%;
        }

        .btn-login:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(34, 197, 94, 0.4);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .forgot-password {
            display: block;
            text-align: center;
            margin-top: 2rem;
            color: var(--verde-acento);
            text-decoration: none;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .forgot-password:hover {
            color: var(--verde-hover);
            transform: translateY(-1px);
        }

        .alert {
            margin-bottom: 2rem;
            padding: 1.25rem 1.5rem;
            border-radius: 12px;
            border: 1px solid rgba(239, 68, 68, 0.3);
            background-color: rgba(239, 68, 68, 0.1);
            color: #dc2626;
            font-size: 1rem;
            font-weight: 500;
        }

        .footer-text {
            position: absolute;
            bottom: 2rem;
            left: 50%;
            transform: translateX(-50%);
            color: var(--gris-texto);
            font-size: 0.85rem;
            text-align: center;
        }

        /* Decorative elements */
        .login-side::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, var(--verde-sutil) 0%, transparent 70%);
            opacity: 0.5;
            z-index: 0;
        }

        .login-container {
            position: relative;
            z-index: 1;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .login-side {
                flex: 0 0 550px;
                padding: 2rem;
            }
        }

        @media (max-width: 768px) {
            .login-wrapper {
                flex-direction: column;
            }

            .background-side {
                flex: 0 0 40vh;
            }

            .login-side {
                flex: 1;
                padding: 2rem;
            }

            .welcome-title {
                font-size: 2.5rem;
            }

            .welcome-subtitle {
                font-size: 1.1rem;
            }

            .login-title {
                font-size: 1.75rem;
            }
        }

        @media (max-width: 480px) {
            .background-side {
                flex: 0 0 30vh;
            }

            .login-side {
                padding: 1.5rem;
            }

            .welcome-title {
                font-size: 2rem;
            }

            .login-container {
                max-width: 100%;
            }

            .form-control {
                padding: 1rem 1rem 1rem 3rem;
                font-size: 1rem;
            }

            .input-icon {
                left: 1rem;
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <!-- Left side - Background Image -->
        <div class="background-side">
            <div class="background-content">
                <h1 class="welcome-title">Bienvenido</h1>
                <p class="welcome-subtitle">
                    Sistema de Administración Académica del Colegio Guatemalam. 
                    Gestiona de manera eficiente toda la información educativa.
                </p>
                
                <div class="feature-highlight">
                    <div class="feature-icon">
                        <i class="fas fa-graduation-cap"></i>
                    </div>
                    <h3 style="margin-bottom: 1rem; font-weight: 600;">Educación de Calidad</h3>
                    <p style="opacity: 0.9;">Accede a todas las herramientas necesarias para la gestión académica y administrativa.</p>
                </div>
            </div>
        </div>

        <!-- Right side - Login Form (Larger) -->
        <div class="login-side">
            <div class="login-container">
                <!-- Logo above credentials -->
                <div class="logo-container">
                    <img src="/images/image.webp" alt="Logo Colegio Guatemalam" class="school-logo">
                    <h2 class="school-name">Colegio Guatemalam</h2>
                    <p class="school-tagline">Sistema de Administración</p>
                </div>

                <div class="login-header">
                    <h2 class="login-title">Iniciar Sesión</h2>
                    <p class="login-subtitle">Ingresa tus credenciales para acceder al sistema</p>
                </div>

                @if($errors->any())
                <div class="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ $errors->first('auth') }}
                </div>
                @endif

                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    
                    <div class="form-group">
                        <label for="CORREO_O_PERFIL" class="form-label">Correo o Perfil</label>
                        <div class="input-wrapper">
                            <input 
                                type="text" 
                                class="form-control" 
                                id="CORREO_O_PERFIL" 
                                name="CORREO_O_PERFIL" 
                                placeholder="Ingresa tu correo o perfil"
                                value="{{ old('CORREO_O_PERFIL') }}" 
                                required 
                                autofocus
                            >
                            <i class="fas fa-user input-icon"></i>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="CLAVE_PERFIL" class="form-label">Contraseña</label>
                        <div class="input-wrapper">
                            <input 
                                type="password" 
                                class="form-control" 
                                id="CLAVE_PERFIL" 
                                name="CLAVE_PERFIL" 
                                placeholder="Ingresa tu contraseña"
                                required
                            >
                            <i class="fas fa-lock input-icon"></i>
                        </div>
                    </div>

                    <button type="submit" class="btn-login">
                        <i class="fas fa-sign-in-alt me-2"></i>
                        Iniciar Sesión
                    </button>

                    <a href="#" class="forgot-password">¿Olvidaste tu contraseña?</a>
                </form>

            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>