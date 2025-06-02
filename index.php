<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FitAssist Pro - Revoluciona tu Fitness</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@700;900&display=swap" rel="stylesheet">
  <style>
    :root {
      --primary: #121212;
      --secondary: #1DB954;
      --accent: #FF5F1F;
      --neon: #00F5FF;
      --light: #F8F9FA;
    }

    body {
      font-family: 'Montserrat', sans-serif;
      background: url('https://images.unsplash.com/photo-1605296867304-46d5465a13f1?auto=format&fit=crop&w=1950&q=80') no-repeat center center fixed;
      background-size: cover;
      color: var(--light);
      min-height: 100vh;
      overflow: hidden;
      position: relative;
    }

    .navbar {
      background-color: rgba(0, 0, 0, 0.7);
    }

    .navbar-brand,
    .nav-link {
      color: var(--light) !important;
    }

    .nav-link:hover {
      color: var(--neon) !important;
    }

    .particles {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      z-index: 0;
    }

    .particle {
      position: absolute;
      background: var(--secondary);
      border-radius: 50%;
      opacity: 0.6;
      animation: float 15s infinite linear;
    }

    @keyframes float {
      0% { transform: translateY(0) rotate(0deg); }
      50% { transform: translateY(-100px) rotate(180deg); }
      100% { transform: translateY(0) rotate(360deg); }
    }

    .card-welcome {
      background: rgba(18, 18, 18, 0.85);
      border-radius: 20px;
      border: 1px solid rgba(29, 185, 84, 0.3);
      box-shadow: 0 0 30px rgba(29, 185, 84, 0.2),
                  0 0 60px rgba(0, 245, 255, 0.1);
      padding: 3rem;
      backdrop-filter: blur(10px);
      transition: all 0.5s ease;
      max-width: 500px;
      width: 100%;
      margin-top: 100px;
      z-index: 1;
      position: relative;
    }

    .card-welcome:hover {
      transform: translateY(-10px);
      box-shadow: 0 0 40px rgba(29, 185, 84, 0.3),
                  0 0 80px rgba(0, 245, 255, 0.2);
    }

    h1 {
      font-family: 'Bebas Neue', sans-serif;
      font-size: 4rem;
      letter-spacing: 3px;
      background: linear-gradient(to right, var(--secondary), var(--neon));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      text-transform: uppercase;
    }

    .lead {
      font-size: 1.5rem;
      margin-bottom: 2.5rem;
      opacity: 0.9;
    }

    .btn-epic, .btn-outline-epic {
      display: block;
      width: 100%;
      padding: 1rem;
      font-size: 1.2rem;
      font-weight: bold;
      letter-spacing: 1px;
      border-radius: 50px;
      margin: 1rem 0;
      text-transform: uppercase;
      position: relative;
      overflow: hidden;
      z-index: 1;
      transition: all 0.4s ease;
    }

    .btn-epic {
      background: linear-gradient(45deg, var(--secondary), var(--neon));
      color: #000;
      border: none;
    }

    .btn-outline-epic {
      background: transparent;
      border: 2px solid var(--secondary);
      color: var(--light);
    }

    .btn-outline-epic:hover {
      background: var(--secondary);
      color: var(--primary);
    }

    .logo-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      background: linear-gradient(to right, var(--secondary), var(--neon));
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }

    @media (max-width: 768px) {
      h1 {
        font-size: 3rem;
      }

      .lead {
        font-size: 1.2rem;
      }

      .card-welcome {
        padding: 2rem;
        margin: 1rem;
      }
    }
  </style>
</head>
<body>

  <!-- Menú de navegación -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#">FitAssist Pro</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Información</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Servicios</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Contacto</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Fondo de partículas -->
  <div class="particles" id="particles"></div>

  <!-- Contenido principal -->
  <div class="container d-flex justify-content-center align-items-center">
    <div class="card-welcome animate__animated animate__fadeInUp">
      <div class="logo-icon"><i class="fas fa-dumbbell"></i></div>
      <h1 class="animate__animated animate__fadeInDown">FitAssist Pro</h1>
      <p class="lead animate__animated animate__fadeIn animate__delay-1s">TRANSFORMA TU CUERPO CON INTELIGENCIA ARTIFICIAL</p>

      <a href="login.php" class="btn btn-epic animate__animated animate__zoomIn animate__delay-2s">
        <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
      </a>
      <a href="registro.php" class="btn btn-outline-epic animate__animated animate__zoomIn animate__delay-2s">
        <i class="fas fa-user-plus me-2"></i> Crear Cuenta
      </a>
    </div>
  </div>

  <!-- Bootstrap JS Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Script de partículas -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const particlesContainer = document.getElementById('particles');
      const colors = ['#1DB954', '#00F5FF', '#FF5F1F'];

      for (let i = 0; i < 25; i++) {
        const particle = document.createElement('div');
        particle.classList.add('particle');
        particle.style.width = Math.random() * 20 + 5 + 'px';
        particle.style.height = particle.style.width;
        particle.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        particle.style.left = Math.random() * 100 + '%';
        particle.style.top = Math.random() * 100 + '%';
        particle.style.animationDuration = Math.random() * 20 + 10 + 's';
        particle.style.animationDelay = Math.random() * 5 + 's';
        particlesContainer.appendChild(particle);
      }
    });
  </script>
</body>
</html>
