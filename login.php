<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Iniciar Sesión - FitAssistant</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
  <style>
    body {
      background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .card {
      padding: 2.5rem;
      border-radius: 1.5rem;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
      background-color: rgba(255, 255, 255, 0.95);
      width: 100%;
      max-width: 450px;
      border: none;
      overflow: hidden;
    }

    .card-header {
      background: transparent;
      border: none;
      padding: 0;
      margin-bottom: 2rem;
      text-align: center;
    }

    .logo {
      font-size: 2.5rem;
      color: #185a9d;
      margin-bottom: 0.5rem;
    }

    h2 {
      font-weight: 700;
      color: #185a9d;
      margin-bottom: 0.5rem;
    }

    .welcome-text {
      color: #6c757d;
      margin-bottom: 1.5rem;
    }

    .form-label {
      font-weight: 600;
      color: #495057;
      margin-bottom: 0.5rem;
    }

    .form-control {
      border-radius: 10px;
      padding: 12px 15px;
      border: 1px solid #ced4da;
      transition: all 0.3s;
    }

    .form-control:focus {
      border-color: #43cea2;
      box-shadow: 0 0 0 0.25rem rgba(67, 206, 162, 0.25);
    }

    .btn-login {
      background: linear-gradient(to right, #43cea2, #185a9d);
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s;
      margin-top: 1rem;
    }

    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
      background: linear-gradient(to right, #3abf94, #144b87);
    }

    .register-link {
      color: #43cea2;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .register-link:hover {
      color: #185a9d;
      text-decoration: underline;
    }

    .input-group-text {
      background-color: #f8f9fa;
      border-radius: 10px 0 0 10px;
      color: #6c757d;
    }

    .password-toggle {
      cursor: pointer;
      transition: all 0.3s;
    }

    .password-toggle:hover {
      color: #43cea2;
    }

    .forgot-password {
      text-align: right;
      margin-top: -0.5rem;
      margin-bottom: 1.5rem;
    }

    .forgot-password a {
      color: #6c757d;
      text-decoration: none;
      font-size: 0.9rem;
      transition: all 0.3s;
    }

    .forgot-password a:hover {
      color: #43cea2;
    }

    /* Animaciones */
    .animate-form {
      animation: fadeInUp 0.5s ease-out forwards;
    }

    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(20px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .social-login {
      margin-top: 2rem;
      text-align: center;
    }

    .social-divider {
      display: flex;
      align-items: center;
      margin: 1.5rem 0;
      color: #6c757d;
    }

    .social-divider::before, .social-divider::after {
      content: "";
      flex: 1;
      border-bottom: 1px solid #dee2e6;
    }

    .social-divider::before {
      margin-right: 1rem;
    }

    .social-divider::after {
      margin-left: 1rem;
    }

    .social-icons {
      display: flex;
      justify-content: center;
      gap: 1rem;
    }

    .social-icon {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-size: 1.2rem;
      transition: all 0.3s;
    }

    .social-icon:hover {
      transform: translateY(-3px);
    }

    .google {
      background-color: #DB4437;
    }

    .facebook {
      background-color: #4267B2;
    }

    .apple {
      background-color: #000000;
    }
  </style>
</head>
<body>
  <div class="card animate__animated animate__fadeInUp">
    <div class="card-header">
      <div class="logo">
        <i class="fas fa-dumbbell"></i>
      </div>
      <h2>Bienvenido de vuelta</h2>
      <p class="welcome-text">Inicia sesión para continuar tu progreso</p>
    </div>
    
    <form action="controller/login_usuario.php" method="POST" class="animate-form">
      <div class="mb-4">
        <label for="correo" class="form-label">Correo electrónico</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" class="form-control" id="correo" name="correo" placeholder="tucorreo@ejemplo.com" required />
        </div>
      </div>
      
      <div class="mb-3">
        <label for="contrasena" class="form-label">Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingresa tu contraseña" required />
          <span class="input-group-text password-toggle" id="togglePassword">
            <i class="fas fa-eye"></i>
          </span>
        </div>
        <div class="forgot-password">
          <a href="recuperar-contrasena.php">¿Olvidaste tu contraseña?</a>
        </div>
      </div>
      
      <button type="submit" class="btn btn-login w-100">
        <i class="fas fa-sign-in-alt me-2"></i> Iniciar Sesión
      </button>
      
      <div class="social-login">
        <div class="social-divider">O continúa con</div>
        <div class="social-icons">
          <a href="#" class="social-icon google"><i class="fab fa-google"></i></a>
          <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
          <a href="#" class="social-icon apple"><i class="fab fa-apple"></i></a>
        </div>
      </div>
      
      <p class="mt-4 text-center">
        ¿No tienes cuenta? <a href="registro.php" class="register-link">Regístrate aquí</a>
      </p>
    </form>
  </div>

  <!-- Bootstrap JS Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Mostrar/ocultar contraseña
    document.getElementById('togglePassword').addEventListener('click', function() {
      const passwordInput = document.getElementById('contrasena');
      const icon = this.querySelector('i');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
      }
    });

    // Validación de formulario
    document.querySelector('form').addEventListener('submit', function(e) {
      const email = document.getElementById('correo').value;
      const password = document.getElementById('contrasena').value;
      
      if (!email || !password) {
        e.preventDefault();
        alert('Por favor completa todos los campos');
      }
    });
  </script>
</body>
</html>