<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recurso No Encontrado - 404</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .error-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        }
        .error-icon {
            font-size: 8rem;
            color: #dc3545;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-20px);
            }
            60% {
                transform: translateY(-10px);
            }
        }
        .btn-custom {
            background: linear-gradient(45deg, #667eea, #764ba2);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            color: white;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            color: white;
        }
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }
        .shape {
            position: absolute;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }
        .shape:nth-child(1) {
            width: 80px;
            height: 80px;
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }
        .shape:nth-child(2) {
            width: 120px;
            height: 120px;
            top: 60%;
            right: 10%;
            animation-delay: 2s;
        }
        .shape:nth-child(3) {
            width: 60px;
            height: 60px;
            bottom: 20%;
            left: 20%;
            animation-delay: 4s;
        }
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>
<body>
    <div class="error-container d-flex align-items-center justify-content-center position-relative">
        <!-- Formas flotantes decorativas -->
        <div class="floating-shapes">
            <div class="shape"></div>
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        
        <div class="container position-relative" style="z-index: 2;">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-xl-6">
                    <div class="error-card p-5 text-center">
                        <!-- Icono de error -->
                        <div class="mb-4">
                            <i class="bi bi-exclamation-triangle error-icon"></i>
                        </div>
                        
                        <!-- Código de error -->
                        <h1 class="display-1 fw-bold text-danger mb-3">404</h1>
                        
                        <!-- Título principal -->
                        <h2 class="h3 fw-bold text-dark mb-3">
                            <i class="bi bi-search me-2"></i>
                            Recurso No Encontrado
                        </h2>
                        
                        <!-- Descripción -->
                        <p class="lead text-muted mb-4">
                            Lo sentimos, el recurso que está buscando no existe o ha sido movido a otra ubicación.
                        </p>
                        
                        <!-- Información adicional -->
                        <div class="alert alert-light border-0 mb-4">
                            <div class="row text-start">
                                <div class="col-12 mb-2">
                                    <strong class="text-muted">
                                        <i class="bi bi-info-circle me-2"></i>Posibles causas:
                                    </strong>
                                </div>
                                <div class="col-12">
                                    <ul class="list-unstyled mb-0 text-muted">
                                        <li class="mb-1">
                                            <i class="bi bi-dot text-danger"></i>
                                            La URL fue escrita incorrectamente
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-dot text-danger"></i>
                                            El recurso fue eliminado o movido
                                        </li>
                                        <li class="mb-1">
                                            <i class="bi bi-dot text-danger"></i>
                                            No tiene permisos para acceder
                                        </li>
                                        <li>
                                            <i class="bi bi-dot text-danger"></i>
                                            El enlace está desactualizado
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botones de acción -->
                        <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center">
                            <button onclick="history.back()" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-arrow-left me-2"></i>
                                Volver Atrás
                            </button>
                            <button onclick="window.location.href='/'" class="btn btn-custom btn-lg">
                                <i class="bi bi-house me-2"></i>
                                Ir al Inicio
                            </button>
                        </div>
                        
                        <!-- Información de contacto -->
                        <div class="mt-5 pt-4 border-top">
                            <p class="text-muted mb-2">
                                <small>¿Necesita ayuda? Contacte al administrador del sistema</small>
                            </p>
                            <div class="d-flex justify-content-center gap-3">
                                <a href="mailto:soporte@sistema.com" class="text-decoration-none text-muted">
                                    <i class="bi bi-envelope me-1"></i>
                                    <small>soporte@sistema.com</small>
                                </a>
                                <span class="text-muted">|</span>
                                <a href="tel:+1234567890" class="text-decoration-none text-muted">
                                    <i class="bi bi-telephone me-1"></i>
                                    <small>+123 456 7890</small>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Agregar efecto de partículas opcional
        document.addEventListener('DOMContentLoaded', function() {
            // Efecto de hover en los botones
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(button => {
                button.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-2px)';
                });
                button.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });
    </script>
</body>
</html>