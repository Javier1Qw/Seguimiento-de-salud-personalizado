<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro - FitAssistant</title>
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
      max-width: 500px;
      border: none;
      overflow: hidden;
    }

    .card-header {
      background: transparent;
      border: none;
      padding: 0;
      margin-bottom: 1.5rem;
    }

    .logo {
      font-size: 2.5rem;
      color: #185a9d;
      margin-bottom: 0.5rem;
    }

    h2 {
      font-weight: 700;
      color: #185a9d;
      margin-bottom: 1rem;
      text-align: center;
    }

    .form-label {
      font-weight: 600;
      color: #495057;
      margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
      border-radius: 10px;
      padding: 12px 15px;
      border: 1px solid #ced4da;
      transition: all 0.3s;
    }

    .form-control:focus, .form-select:focus {
      border-color: #43cea2;
      box-shadow: 0 0 0 0.25rem rgba(67, 206, 162, 0.25);
    }

    .btn-primary {
      background: linear-gradient(to right, #43cea2, #185a9d);
      border: none;
      border-radius: 10px;
      padding: 12px;
      font-weight: 600;
      letter-spacing: 0.5px;
      transition: all 0.3s;
      margin-top: 0.5rem;
    }

    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .login-link {
      color: #43cea2;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s;
    }

    .login-link:hover {
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
  </style>
</head>
<body>
  <div class="card animate__animated animate__fadeInUp">
    <div class="card-header text-center">
      <div class="logo">
        <i class="fas fa-dumbbell"></i>
      </div>
      <h2>Únete a FitAssistant</h2>
      <p class="text-muted">Comienza tu viaje fitness hoy mismo</p>
    </div>
    
    <form action="controller/registrar_usuario.php" method="POST" class="animate-form">
      <div class="mb-4">
        <label for="nombre" class="form-label">Nombre completo</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-user"></i></span>
          <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Juan Pérez" required />
        </div>
      </div>
      
      <div class="mb-4">
        <label for="correo" class="form-label">Correo electrónico</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-envelope"></i></span>
          <input type="email" class="form-control" id="correo" name="correo" placeholder="Ej: usuario@ejemplo.com" required />
        </div>
      </div>
      
      <div class="mb-4">
        <label for="contrasena" class="form-label">Contraseña</label>
        <div class="input-group">
          <span class="input-group-text"><i class="fas fa-lock"></i></span>
          <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Mínimo 8 caracteres" required />
          <span class="input-group-text password-toggle" id="togglePassword">
            <i class="fas fa-eye"></i>
          </span>
        </div>
        <div class="form-text">La contraseña debe contener al menos 8 caracteres</div>
      </div>
      
      <div class="row">
        <div class="col-md-6 mb-4">
          <label for="edad" class="form-label">Edad</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
            <input type="number" class="form-control" id="edad" name="edad" min="10" max="100" required />
          </div>
        </div>
        
        <div class="col-md-6 mb-4">
          <label for="sexo" class="form-label">Sexo</label>
          <select class="form-select" id="sexo" name="sexo" required>
            <option value="" selected disabled>Seleccione</option>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
          </select>
        </div>
      </div>
      
      <div class="row">
        <div class="col-md-6 mb-4">
          <label for="peso" class="form-label">Peso (kg)</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-weight"></i></span>
            <input type="number" step="0.1" class="form-control" id="peso" name="peso" min="30" max="300" placeholder="Ej: 68.5" required />
          </div>
        </div>
        
        <div class="col-md-6 mb-4">
          <label for="estatura" class="form-label">Estatura (m)</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-ruler-vertical"></i></span>
            <input type="number" step="0.01" class="form-control" id="estatura" name="estatura" min="1" max="2.5" placeholder="Ej: 1.75" required />
          </div>
        </div>
      </div>
      
      <button type="submit" class="btn btn-primary w-100 animate__animated animate__pulse animate__slow animate__infinite">
        <i class="fas fa-user-plus me-2"></i> Crear cuenta
      </button>
      
      <p class="mt-4 text-center">
        ¿Ya tienes cuenta? <a href="login.php" class="login-link">Inicia sesión</a>
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
      const password = document.getElementById('contrasena').value;
      
      if (password.length < 8) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 8 caracteres');
        document.getElementById('contrasena').focus();
      }
    });
  </script>
</body>
</html>