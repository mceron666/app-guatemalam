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
        body {
            height: 100vh;
            background-image: url('/images/atitlan.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 1;
        }
        
        .login-container {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 450px;
            padding: 20px;
        }
        
        .logo-container {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        
        .logo {
            max-width: 120px;
            margin-bottom: 0.5rem;
            filter: drop-shadow(0 0 10px rgba(255, 255, 255, 0.5));
        }
        
        .school-title {
            color: white;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
        }
        
        .card {
            border: none;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        .card-header {
            background-color: #0056b3;
            color: white;
            text-align: center;
            border-radius: 15px 15px 0 0 !important;
            padding: 1.5rem 1rem;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e0e0e0;
            background-color: rgba(255, 255, 255, 0.9);
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 0.25rem rgba(0, 86, 179, 0.25);
            border-color: #0056b3;
            background-color: white;
        }
        
        .btn-primary {
            background-color: #0056b3;
            border-color: #0056b3;
            border-radius: 8px;
            padding: 0.75rem;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background-color: #004494;
            border-color: #004494;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 86, 179, 0.3);
        }
        
        .input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }
        
        .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            z-index: 10;
        }
        
        .icon-input {
            padding-left: 40px;
        }
        
        .footer-text {
            margin-top: 1.5rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        }
        
        .forgot-password {
            color: #0056b3;
            transition: all 0.3s;
        }
        
        .forgot-password:hover {
            color: #004494;
            text-decoration: underline !important;
        }
        
        @media (max-width: 576px) {
            .login-container {
                padding: 10px;
            }
            
            .card {
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="logo-container">
            <img src="/images/image.webp" alt="Logo Colegio Guatemalam" class="logo">
            <h2 class="school-title">Colegio Guatemalam</h2>
        </div>
        
        @if($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first('auth') }}
        </div>
        @endif
        
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0">Iniciar Sesión</h4>
            </div>
            <div class="card-body p-4">
                <form method="POST" action="{{ url('/login') }}">
                    @csrf
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" class="form-control icon-input" id="CORREO_O_PERFIL" name="CORREO_O_PERFIL" placeholder="Correo o Perfil" value="{{ old('CORREO_O_PERFIL') }}" required autofocus>
                    </div>
                    
                    <div class="input-group">
                        <span class="input-icon">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" class="form-control icon-input" id="CLAVE_PERFIL" name="CLAVE_PERFIL" placeholder="Contraseña" required>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Iniciar Sesión
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <a href="#" class="forgot-password text-decoration-none">¿Olvidaste tu contraseña?</a>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="footer-text">
            <small>© {{ date('Y') }} Colegio Guatemalam. Todos los derechos reservados.</small>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>