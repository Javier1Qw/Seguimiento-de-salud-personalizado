<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

// Obtener datos del usuario para saludar
$stmt = $conn->prepare("SELECT nombre FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();

$nombre = $usuario ? $usuario['nombre'] : "Usuario";

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi Espacio - FitAssistant</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@700;900&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0a2e38;  /* Verde oscuro militar */
            --secondary: #2d7d46;  /* Verde bosque */
            --accent: #d4af37;  /* Dorado */
            --light: #e8e8e8;  /* Gris claro */
            --dark: #121212;  /* Casi negro */
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--primary), var(--dark));
            min-height: 100vh;
            color: var(--light);
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }
        
        .hero-section {
            position: relative;
            padding: 5rem 0;
            text-align: center;
            z-index: 1;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1350&q=80') no-repeat center center/cover;
            opacity: 0.15;
            z-index: -1;
        }
        
        .welcome-text {
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(to right, var(--light), var(--accent));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }
        
        .subtitle {
            font-size: 1.5rem;
            margin-bottom: 3rem;
            opacity: 0.9;
        }
        
        .card-panel {
            background: rgba(10, 46, 56, 0.7);  /* Verde oscuro con transparencia */
            backdrop-filter: blur(10px);
            border-radius: 15px;
            border: 1px solid rgba(45, 125, 70, 0.3);  /* Borde verde bosque */
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            padding: 3rem;
            max-width: 800px;
            margin: 0 auto;
            transition: all 0.5s ease;
        }
        
        .card-panel:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 45px rgba(0,0,0,0.4);
        }
        
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 1rem 2rem;
            margin: 0.5rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1.1rem;
            letter-spacing: 1px;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            z-index: 1;
            border: 2px solid var(--accent);
            min-width: 220px;
            color: var(--dark);
        }
        
        .btn-action::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--accent), #f2d272);
            z-index: -1;
            transition: all 0.4s ease;
        }
        
        .btn-action:hover {
            color: var(--dark);
            transform: translateY(-5px);
        }
        
        .btn-action:hover::before {
            transform: scale(1.05);
        }
        
        .btn-routine::before {
            background: linear-gradient(45deg, var(--secondary), #4caF50);
        }
        
        .btn-diet::before {
            background: linear-gradient(45deg, #8bc34a, #cddc39);
        }
        
        .btn-icon {
            margin-right: 10px;
            font-size: 1.3rem;
        }
        
        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
            overflow: hidden;
        }
        
        .floating {
            position: absolute;
            background: rgba(45, 125, 70, 0.1);  /* Verde bosque transparente */
            border: 1px solid rgba(45, 125, 70, 0.3);
            border-radius: 50%;
            animation: float 15s infinite linear;
        }
        
        /* Resto de las animaciones y estilos se mantienen igual... */
        
        .stats-container {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            margin: 2rem 0;
        }
        
        .stat-card {
            background: rgba(10, 46, 56, 0.8);  /* Verde oscuro */
            border-radius: 10px;
            padding: 1.5rem;
            margin: 0.5rem;
            min-width: 150px;
            text-align: center;
            backdrop-filter: blur(5px);
            border: 1px solid var(--accent);
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
            background: rgba(45, 125, 70, 0.6);  /* Verde bosque */
        }
        
        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(to right, var(--accent), #f2d272);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
            color: var(--light);
        }
        
        @media (max-width: 768px) {
            .welcome-text {
                font-size: 2.5rem;
            }
            
            .subtitle {
                font-size: 1.2rem;
            }
            
            .card-panel {
                padding: 2rem;
            }
            
            .btn-action {
                min-width: 100%;
                margin: 0.5rem 0;
            }
        }
    </style>
</head>
<body>
    <div class="floating-elements">
        <div class="floating" style="width: 150px; height: 150px; top: 10%; left: 10%;"></div>
        <div class="floating" style="width: 250px; height: 250px; top: 60%; left: 80%;"></div>
        <div class="floating" style="width: 100px; height: 100px; top: 80%; left: 20%;"></div>
        <div class="floating" style="width: 200px; height: 200px; top: 30%; left: 70%;"></div>
    </div>
    
    <div class="hero-section">
        <div class="container">
            <div class="card-panel animate__animated animate__fadeInUp">
                <h1 class="welcome-text">¡BIENVENIDO, <?php echo strtoupper(htmlspecialchars($nombre)); ?>!</h1>
                <p class="subtitle">Tu centro de control para alcanzar el máximo rendimiento</p>
                
                <div class="stats-container">
                    <div class="stat-card animate__animated animate__fadeInLeft animate__delay-1s">
                        <div class="stat-value">+95%</div>
                        <div class="stat-label">EFECTIVIDAD</div>
                    </div>
                    <div class="stat-card animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="stat-value">24/7</div>
                        <div class="stat-label">DISPONIBLE</div>
                    </div>
                    <div class="stat-card animate__animated animate__fadeInRight animate__delay-1s">
                        <div class="stat-value">100%</div>
                        <div class="stat-label">PERSONALIZADO</div>
                    </div>
                </div>
                
                <div class="d-flex flex-wrap justify-content-center mt-5">
                    <a href="rutina_perso.php" class="btn-action btn-routine animate__animated animate__zoomIn animate__delay-2s">
                        <i class="fas fa-dumbbell btn-icon"></i> MI RUTINA
                    </a>
                    <a href="dieta_perso.php" class="btn-action btn-diet animate__animated animate__zoomIn animate__delay-2s">
                        <i class="fas fa-utensils btn-icon"></i> MI DIETA
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto de partículas al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            const colors = ['#2d7d46', '#d4af37', '#8bc34a', '#4caf50', '#cddc39'];
            
            for (let i = 0; i < 30; i++) {
                setTimeout(() => {
                    const particle = document.createElement('div');
                    particle.style.position = 'fixed';
                    particle.style.width = Math.random() * 8 + 2 + 'px';
                    particle.style.height = Math.random() * 8 + 2 + 'px';
                    particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                    particle.style.left = Math.random() * window.innerWidth + 'px';
                    particle.style.top = -10 + 'px';
                    particle.style.borderRadius = '50%';
                    particle.style.zIndex = '9999';
                    particle.style.opacity = '0.7';
                    document.body.appendChild(particle);
                    
                    const animation = particle.animate([
                        { top: -10 + 'px', transform: 'rotate(0deg)' },
                        { top: window.innerHeight + 'px', transform: 'rotate(360deg)' }
                    ], {
                        duration: Math.random() * 3000 + 2000,
                        easing: 'cubic-bezier(0.1, 0.2, 0.3, 1)'
                    });
                    
                    animation.onfinish = () => particle.remove();
                }, Math.random() * 500);
            }
        });
    </script>
</body>
</html>