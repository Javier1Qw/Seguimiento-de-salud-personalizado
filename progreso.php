<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>🏆 Mi Progreso Fitness - Lunes</title>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --secondary: #3f37c9;
      --accent: #4cc9f0;
      --success: #4ad66d;
      --warning: #f8961e;
      --danger: #f94144;
      --light: #f8f9fa;
      --dark: #212529;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
      padding: 20px;
      color: var(--dark);
      min-height: 100vh;
    }
    
    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }
    
    header {
      text-align: center;
      margin-bottom: 40px;
      animation: fadeInDown 1s;
    }
    
    h1 {
      font-size: 2.5rem;
      color: var(--primary);
      margin-bottom: 10px;
      text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    }
    
    .subtitle {
      font-size: 1.2rem;
      color: var(--secondary);
      font-weight: 300;
    }
    
    .dashboard {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
      gap: 30px;
      margin-bottom: 40px;
    }
    
    .card {
      background: white;
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      transition: transform 0.3s, box-shadow 0.3s;
      animation: fadeIn 1s;
    }
    
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 15px 35px rgba(0,0,0,0.15);
    }
    
    .card-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    
    .card-icon {
      font-size: 1.8rem;
      margin-right: 15px;
      color: var(--primary);
    }
    
    .card-title {
      font-size: 1.3rem;
      font-weight: 600;
      color: var(--secondary);
      margin: 0;
    }
    
    .chart-container {
      position: relative;
      height: 250px;
      width: 100%;
    }
    
    .stats-grid {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 20px;
      margin-bottom: 30px;
    }
    
    .stat-card {
      background: white;
      border-radius: 15px;
      padding: 20px;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.05);
      transition: all 0.3s;
    }
    
    .stat-card:hover {
      transform: scale(1.03);
      box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }
    
    .stat-value {
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--primary);
      margin: 10px 0;
    }
    
    .stat-label {
      font-size: 1rem;
      color: #6c757d;
    }
    
    .exercise-list {
      background: white;
      border-radius: 20px;
      padding: 25px;
      box-shadow: 0 10px 30px rgba(0,0,0,0.1);
      animation: fadeInUp 1s;
    }
    
    .exercise-list h2 {
      color: var(--secondary);
      margin-top: 0;
      margin-bottom: 20px;
      display: flex;
      align-items: center;
    }
    
    .exercise-list h2::before {
      content: "🏋️‍♂️";
      margin-right: 10px;
    }
    
    .exercise-item {
      display: flex;
      align-items: center;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 10px;
      background: #f8f9fa;
      transition: all 0.3s;
    }
    
    .exercise-item:hover {
      background: #e9ecef;
      transform: translateX(5px);
    }
    
    .exercise-icon {
      font-size: 1.5rem;
      margin-right: 15px;
      width: 40px;
      text-align: center;
    }
    
    .exercise-name {
      flex-grow: 1;
      font-weight: 500;
    }
    
    .exercise-duration {
      color: var(--primary);
      font-weight: 600;
    }
    
    .btn {
      display: inline-block;
      padding: 12px 30px;
      border-radius: 50px;
      font-weight: 600;
      text-align: center;
      text-decoration: none;
      cursor: pointer;
      transition: all 0.3s;
      border: none;
      font-size: 1rem;
    }
    
    .btn-primary {
      background: var(--primary);
      color: white;
    }
    
    .btn-primary:hover {
      background: var(--secondary);
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(67, 97, 238, 0.4);
    }
    
    .btn-danger {
      background: var(--danger);
      color: white;
    }
    
    .btn-danger:hover {
      background: #d32f2f;
      transform: translateY(-2px);
      box-shadow: 0 5px 15px rgba(248, 65, 68, 0.4);
    }
    
    .text-center {
      text-align: center;
    }
    
    .mt-4 {
      margin-top: 40px;
    }
    
    .progress-ring {
      position: relative;
      width: 120px;
      height: 120px;
      margin: 0 auto;
    }
    
    .progress-ring__circle {
      transform: rotate(-90deg);
      transform-origin: 50% 50%;
    }
    
    .progress-ring__circle-bg {
      stroke: #e9ecef;
      stroke-width: 8;
      fill: none;
    }
    
    .progress-ring__circle-progress {
      stroke: var(--success);
      stroke-width: 8;
      stroke-linecap: round;
      fill: none;
      transition: stroke-dashoffset 0.5s;
    }
    
    .progress-percent {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 1.5rem;
      font-weight: 700;
      color: var(--dark);
    }
    
    .celebration {
      font-size: 1.2rem;
      color: var(--success);
      font-weight: 600;
      margin-top: 10px;
      animation: pulse 2s infinite;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); }
      50% { transform: scale(1.05); }
      100% { transform: scale(1); }
    }
    
    @keyframes confetti {
      0% { transform: translateY(0) rotate(0deg); opacity: 1; }
      100% { transform: translateY(-100vh) rotate(720deg); opacity: 0; }
    }
    
    .confetti {
      position: fixed;
      width: 10px;
      height: 10px;
      background-color: #f00;
      opacity: 0;
      animation: confetti 3s ease-out forwards;
    }
    
    @media (max-width: 768px) {
      .dashboard {
        grid-template-columns: 1fr;
      }
      
      .stats-grid {
        grid-template-columns: 1fr;
      }
      
      h1 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header class="animate__animated animate__fadeInDown">
      <h1>Mi Progreso Fitness</h1>
      <p class="subtitle">Lunes, 2 de junio 2025</p>
    </header>
    
    <div class="stats-grid">
      <div class="stat-card animate__animated animate__fadeInLeft">
        <p class="stat-label">Ejercicios completados</p>
        <div class="stat-value">3</div>
        <p>de 3 objetivos</p>
        <div class="celebration">¡Meta alcanzada! 🎉</div>
      </div>
      
      <div class="stat-card animate__animated animate__fadeInUp">
        <p class="stat-label">Porcentaje completado</p>
        <div class="progress-ring">
          <svg width="120" height="120">
            <circle class="progress-ring__circle-bg" r="52" cx="60" cy="60"></circle>
            <circle class="progress-ring__circle-progress" r="52" cx="60" cy="60" stroke-dasharray="326.56" stroke-dashoffset="0"></circle>
          </svg>
          <div class="progress-percent">100%</div>
        </div>
      </div>
      
      <div class="stat-card animate__animated animate__fadeInRight">
        <p class="stat-label">Tiempo total</p>
        <div class="stat-value">45<span style="font-size: 1rem;">min</span></div>
        <p>de 60min objetivo</p>
      </div>
    </div>
    
    <div class="dashboard">
      <div class="card">
        <div class="card-header">
          <div class="card-icon">📈</div>
          <h3 class="card-title">Progreso diario</h3>
        </div>
        <div class="chart-container">
          <canvas id="lineChart"></canvas>
        </div>
      </div>
      
      <div class="card">
        <div class="card-header">
          <div class="card-icon">📊</div>
          <h3 class="card-title">Distribución de ejercicios</h3>
        </div>
        <div class="chart-container">
          <canvas id="pieChart"></canvas>
        </div>
      </div>
    </div>
    
    <div class="exercise-list">
      <h2>Ejercicios realizados hoy</h2>
      
      <div class="exercise-item">
        <div class="exercise-icon">🚶‍♂️</div>
        <div class="exercise-name">Caminata rápida</div>
        <div class="exercise-duration">20 min</div>
      </div>
      
      <div class="exercise-item">
        <div class="exercise-icon">💪</div>
        <div class="exercise-name">Abdominales</div>
        <div class="exercise-duration">3 series x 15 rep</div>
      </div>
      
      <div class="exercise-item">
        <div class="exercise-icon">🚴‍♂️</div>
        <div class="exercise-name">Bicicleta estática</div>
        <div class="exercise-duration">15 min</div>
      </div>
    </div>
    
    <div class="text-center mt-4">
      <button class="btn btn-danger" onclick="location.href='index.php'">
        🔒 Cerrar sesión
      </button>
    </div>
  </div>

  <script>
    // Datos actualizados
    const dias = ["Lunes"];
    const completados = [3]; // 3 ejercicios realizados de 3 objetivos
    const porcentajes = [100]; // 100% completado
    
    // Colores personalizados
    const colors = {
      primary: '#4361ee',
      secondary: '#3f37c9',
      accent: '#4cc9f0',
      success: '#4ad66d',
      warning: '#f8961e',
      danger: '#f94144'
    };

    // Gráfico de línea para el lunes
    new Chart(document.getElementById('lineChart'), {
      type: 'line',
      data: {
        labels: dias,
        datasets: [{
          label: 'Ejercicios Completados',
          data: completados,
          borderColor: colors.success,
          backgroundColor: 'rgba(74, 214, 109, 0.1)',
          borderWidth: 3,
          tension: 0.4,
          fill: true,
          pointRadius: 6,
          pointHoverRadius: 8,
          pointBackgroundColor: colors.success,
          pointBorderColor: '#fff',
          pointBorderWidth: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false
          },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 12
            },
            padding: 12,
            cornerRadius: 10,
            displayColors: false
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 3,
            ticks: {
              stepSize: 1
            },
            grid: {
              color: 'rgba(0,0,0,0.05)'
            }
          },
          x: {
            grid: {
              display: false
            }
          }
        }
      }
    });

    // Gráfico de tipo de ejercicios realizados
    new Chart(document.getElementById('pieChart'), {
      type: 'doughnut',
      data: {
        labels: ['Caminata', 'Abdominales', 'Bicicleta'],
        datasets: [{
          label: 'Distribución de ejercicios',
          data: [1, 1, 1],  // 1 de cada tipo
          backgroundColor: [colors.success, colors.primary, colors.warning],
          borderWidth: 0,
          hoverOffset: 15
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              padding: 20,
              usePointStyle: true,
              pointStyle: 'circle',
              font: {
                size: 12
              }
            }
          },
          tooltip: {
            backgroundColor: 'rgba(0,0,0,0.8)',
            titleFont: {
              size: 14,
              weight: 'bold'
            },
            bodyFont: {
              size: 12
            },
            padding: 12,
            cornerRadius: 10
          }
        }
      }
    });
    
    // Animación del círculo de progreso (100%)
    const circle = document.querySelector('.progress-ring__circle-progress');
    const radius = circle.r.baseVal.value;
    const circumference = 2 * Math.PI * radius;
    const percent = 100;
    
    circle.style.strokeDasharray = `${circumference} ${circumference}`;
    circle.style.strokeDashoffset = circumference - (percent / 100) * circumference;
    
    // Efecto de confeti al cargar (porque completó todos los ejercicios)
    function createConfetti() {
      const colors = ['#4361ee', '#4cc9f0', '#4ad66d', '#f8961e', '#f94144'];
      for (let i = 0; i < 50; i++) {
        const confetti = document.createElement('div');
        confetti.className = 'confetti';
        confetti.style.left = Math.random() * 100 + 'vw';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.width = Math.random() * 10 + 5 + 'px';
        confetti.style.height = Math.random() * 10 + 5 + 'px';
        confetti.style.animationDelay = Math.random() * 3 + 's';
        document.body.appendChild(confetti);
      }
    }
    
    // Solo mostrar confeti si se completaron todos los ejercicios
    if (completados[0] === 3) {
      setTimeout(createConfetti, 1000);
    }
  </script>
</body>
</html>