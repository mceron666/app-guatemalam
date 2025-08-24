<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Colegio Guatemalam</title>
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
            --rojo-error: #ef4444;
            --rojo-error-bg: rgba(239, 68, 68, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, var(--verde-oscuro) 0%, var(--verde-principal) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .change-password-container {
            background: var(--blanco);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            position: relative;
            overflow: hidden;
        }

        .change-password-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--verde-acento), var(--verde-hover));
        }

        .header-section {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .security-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--verde-acento), var(--verde-hover));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 20px rgba(34, 197, 94, 0.3);
        }

        .security-icon i {
            font-size: 2rem;
            color: white;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 800;
            color: var(--gris-oscuro);
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: var(--gris-texto);
            font-size: 1rem;
            line-height: 1.5;
        }

        .user-info {
            background: var(--gris-muy-claro);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-left: 4px solid var(--verde-acento);
        }

        .user-name {
            font-weight: 600;
            color: var(--gris-oscuro);
            font-size: 1.1rem;
        }

        .user-email {
            color: var(--gris-texto);
            font-size: 0.9rem;
            margin-top: 0.25rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-size: 0.95rem;
            font-weight: 600;
            color: var(--gris-oscuro);
            margin-bottom: 0.5rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-control {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid var(--gris-medio);
            border-radius: 10px;
            font-size: 1rem;
            background-color: var(--blanco);
            color: var(--gris-oscuro);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--verde-acento);
            box-shadow: 0 0 0 3px var(--verde-sutil);
        }

        .form-control.is-invalid {
            border-color: var(--rojo-error);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gris-texto);
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        .form-control:focus + .input-icon {
            color: var(--verde-acento);
        }

        .password-requirements {
            background: var(--gris-muy-claro);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 1rem;
            font-size: 0.85rem;
        }

        .requirement-title {
            font-weight: 600;
            color: var(--gris-oscuro);
            margin-bottom: 0.5rem;
        }

        .requirement-list {
            list-style: none;
            padding: 0;
        }

        .requirement-list li {
            color: var(--gris-texto);
            margin-bottom: 0.25rem;
            padding-left: 1.5rem;
            position: relative;
        }

        .requirement-list li::before {
            content: '•';
            color: var(--verde-acento);
            font-weight: bold;
            position: absolute;
            left: 0;
        }

        .btn-change-password {
            width: 100%;
            padding: 1rem 1.5rem;
            background: linear-gradient(135deg, var(--verde-acento) 0%, var(--verde-hover) 100%);
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            margin-top: 1rem;
        }

        .btn-change-password:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(34, 197, 94, 0.4);
        }

        .btn-change-password:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }

        .alert {
            margin-bottom: 1.5rem;
            padding: 1rem 1.25rem;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .alert-danger {
            border: 1px solid rgba(239, 68, 68, 0.3);
            background-color: var(--rojo-error-bg);
            color: var(--rojo-error);
        }

        .invalid-feedback {
            display: block;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: var(--rojo-error);
        }

        .back-to-login {
            text-align: center;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--gris-medio);
        }

        .back-to-login a {
            color: var(--gris-texto);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .back-to-login a:hover {
            color: var(--verde-acento);
        }

        @media (max-width: 768px) {
            body {
                padding: 1rem;
            }
            
            .change-password-container {
                padding: 2rem;
            }
            
            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="change-password-container">
        <div class="header-section">
            <div class="security-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1 class="page-title">Cambiar Contraseña</h1>
            <p class="page-subtitle">
                Por seguridad, necesitas establecer una nueva contraseña antes de continuar.
            </p>
        </div>

        <div class="user-info">
            <div class="user-name">{{ $usuario['NOMBRES_PERSONA'] }} {{ $usuario['APELLIDOS_PERSONA'] }}</div>
            <div class="user-email">{{ $usuario['CORREO_PERSONA'] }}</div>
        </div>

        @if($errors->any())
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            {{ $errors->first('password') ?: $errors->first() }}
        </div>
        @endif

        <form method="POST" action="{{ url('/cambiar-password') }}">
            @csrf

            <div class="form-group">
                <label for="nueva_clave" class="form-label">Nueva Contraseña</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        class="form-control @error('nueva_clave') is-invalid @enderror" 
                        id="nueva_clave" 
                        name="nueva_clave" 
                        placeholder="Ingresa tu nueva contraseña"
                        required 
                        autofocus
                    >
                    <i class="fas fa-lock input-icon"></i>
                </div>
                @error('nueva_clave')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="nueva_clave_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                <div class="input-wrapper">
                    <input 
                        type="password" 
                        class="form-control @error('nueva_clave_confirmation') is-invalid @enderror" 
                        id="nueva_clave_confirmation" 
                        name="nueva_clave_confirmation" 
                        placeholder="Confirma tu nueva contraseña"
                        required
                    >
                    <i class="fas fa-lock input-icon"></i>
                </div>
                @error('nueva_clave_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="password-requirements">
                <div class="requirement-title">La contraseña debe cumplir con:</div>
                <ul class="requirement-list">
                    <li>Mínimo 8 caracteres de longitud</li>
                    <li>Al menos una letra minúscula (a-z)</li>
                    <li>Al menos una letra mayúscula (A-Z)</li>
                    <li>Al menos un número (0-9)</li>
                    <li>Al menos un carácter especial (@$!%*?&)</li>
                </ul>
            </div>

            <button type="submit" class="btn-change-password">
                <i class="fas fa-key me-2"></i>
                Cambiar Contraseña
            </button>
        </form>

        <div class="back-to-login">
            <a href="{{ url('/login') }}">
                <i class="fas fa-arrow-left me-1"></i>
                Volver al inicio de sesión
            </a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
