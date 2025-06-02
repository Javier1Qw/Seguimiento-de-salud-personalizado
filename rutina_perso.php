<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "assit_fit");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Función para obtener la rutina con estilos mejorados
function obtenerRutinaPersonalizada($usuario_id, $conexion) {
    // Obtener la última evaluación
    $query = "SELECT * FROM evaluaciones WHERE usuario_id = ? ORDER BY fecha_creacion DESC LIMIT 1";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        return "
        <div class='error-container'>
            <div class='error-icon'>⚠️</div>
            <h3>Evaluación Requerida</h3>
            <p>Necesitas completar tu evaluación inicial para generar tu rutina personalizada.</p>
            <button class='cta-button'>Hacer Evaluación</button>
        </div>";
    }

    $eval = $resultado->fetch_assoc();

    // Lógica de búsqueda de rutina (igual que antes)
    $query_rutina = "
        SELECT * FROM rutinas_base 
        WHERE estado_salud = ? 
          AND objetivo = ? 
          AND tiempo_disponible = ? 
          AND tipo_ejercicio_preferido = ?
        LIMIT 1
    ";
    $stmt2 = $conexion->prepare($query_rutina);
    $stmt2->bind_param("ssss", $eval['estado_salud'], $eval['objetivo'], $eval['tiempo_disponible'], $eval['tipo_ejercicio_preferido']);
    $stmt2->execute();
    $rutina_resultado = $stmt2->get_result();

    // Búsquedas aproximadas (manteniendo la lógica original)
    if ($rutina_resultado->num_rows === 0) {
        $query_rutina_aprox = "
            SELECT * FROM rutinas_base 
            WHERE estado_salud = ? 
              AND tipo_ejercicio_preferido = ?
            ORDER BY id ASC
            LIMIT 1
        ";
        $stmt3 = $conexion->prepare($query_rutina_aprox);
        $stmt3->bind_param("ss", $eval['estado_salud'], $eval['tipo_ejercicio_preferido']);
        $stmt3->execute();
        $rutina_resultado = $stmt3->get_result();
    }

    if ($rutina_resultado->num_rows === 0) {
        $query_rutina_aprox2 = "
            SELECT * FROM rutinas_base 
            WHERE estado_salud = ?
            ORDER BY id ASC
            LIMIT 1
        ";
        $stmt4 = $conexion->prepare($query_rutina_aprox2);
        $stmt4->bind_param("s", $eval['estado_salud']);
        $stmt4->execute();
        $rutina_resultado = $stmt4->get_result();
    }

    if ($rutina_resultado->num_rows === 0) {
        $query_rutina_aprox3 = "
            SELECT * FROM rutinas_base 
            ORDER BY id ASC
            LIMIT 1
        ";
        $resultado_final = $conexion->query($query_rutina_aprox3);
        $rutina_resultado = $resultado_final;
    }

    if ($rutina_resultado->num_rows === 0) {
        return "
        <div class='error-container'>
            <div class='error-icon'>🔄</div>
            <h3>Rutinas en Desarrollo</h3>
            <p>Estamos preparando rutinas increíbles para tu perfil. ¡Vuelve pronto!</p>
        </div>";
    }

    $rutina_data = $rutina_resultado->fetch_assoc();
    $ejercicios = explode("|", $rutina_data['rutina']);

    // Iconos y colores mejorados
    $ejercicios_data = [
        "Caminata" => ["icon" => "🚶‍♂️", "color" => "#4CAF50", "category" => "Cardio"],
        "Bicicleta" => ["icon" => "🚴‍♀️", "color" => "#2196F3", "category" => "Cardio"],
        "Abdominales" => ["icon" => "💪", "color" => "#FF5722", "category" => "Fuerza"],
        "Sentadillas" => ["icon" => "🏋️‍♀️", "color" => "#9C27B0", "category" => "Fuerza"],
        "Flexiones" => ["icon" => "🤸‍♂️", "color" => "#E91E63", "category" => "Fuerza"],
        "Peso muerto" => ["icon" => "🏋️‍♂️", "color" => "#795548", "category" => "Fuerza"],
        "Estiramientos" => ["icon" => "🧘‍♀️", "color" => "#00BCD4", "category" => "Flexibilidad"],
        "Yoga" => ["icon" => "🧘‍♀️", "color" => "#673AB7", "category" => "Flexibilidad"],
        "Burpees" => ["icon" => "🔥", "color" => "#F44336", "category" => "HIIT"],
        "Escaladores" => ["icon" => "⛰️", "color" => "#607D8B", "category" => "HIIT"],
        "Jumping jacks" => ["icon" => "🤾‍♀️", "color" => "#FF9800", "category" => "Cardio"],
        "Circuito" => ["icon" => "🔁", "color" => "#3F51B5", "category" => "Mixto"],
        "Ciclismo" => ["icon" => "🚲", "color" => "#009688", "category" => "Cardio"],
        "Tai Chi" => ["icon" => "☯️", "color" => "#8BC34A", "category" => "Relajación"],
        "Respiración" => ["icon" => "🌬️", "color" => "#CDDC39", "category" => "Relajación"],
        "Banda elástica" => ["icon" => "🎯", "color" => "#FFC107", "category" => "Resistencia"]
    ];

    // CSS moderno y profesional
    $css = "
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        
        .routine-container {
            font-family: 'Inter', sans-serif;
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .routine-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 100 100\"><defs><pattern id=\"grid\" width=\"10\" height=\"10\" patternUnits=\"userSpaceOnUse\"><path d=\"M 10 0 L 0 0 0 10\" fill=\"none\" stroke=\"%23ffffff\" stroke-width=\"0.1\" opacity=\"0.1\"/></pattern></defs><rect width=\"100\" height=\"100\" fill=\"url(%23grid)\"/></svg>');
            pointer-events: none;
        }
        
        .routine-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }
        
        .routine-title {
            font-size: 3rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s ease-out;
        }
        
        .routine-subtitle {
            font-size: 1.2rem;
            color: rgba(255,255,255,0.9);
            font-weight: 300;
            animation: fadeInUp 0.8s ease-out 0.2s both;
        }
        
        .exercises-grid {
            display: grid;
            gap: 1.5rem;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }
        
        .exercise-card {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }
        
        .exercise-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: var(--card-color);
            transition: width 0.3s ease;
        }
        
        .exercise-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        .exercise-card:hover::before {
            width: 100%;
            opacity: 0.1;
        }
        
        .exercise-card.completed {
            opacity: 0.7;
            background: rgba(76, 175, 80, 0.1);
        }
        
        .exercise-card.completed::before {
            background: #4CAF50;
        }
        
        .exercise-icon {
            font-size: 3rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
            animation: bounce 2s infinite;
        }
        
        .exercise-content {
            flex: 1;
        }
        
        .exercise-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        
        .exercise-category {
            font-size: 0.9rem;
            color: var(--card-color);
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .complete-btn {
            background: #4CAF50;
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 80px;
        }
        
        .complete-btn:hover {
            background: #45a049;
            transform: scale(1.05);
        }
        
        .complete-btn.completed {
            background: #2196F3;
            cursor: default;
        }
        
        .complete-btn.completed:hover {
            transform: none;
        }
        
        .motivation-section {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 3rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }
        
        .motivation-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            animation: pulse 2s infinite;
        }
        
        .motivation-text {
            color: white;
            font-size: 1.1rem;
            line-height: 1.6;
            font-weight: 400;
        }
        
        .stats-bar {
            display: flex;
            justify-content: space-around;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1rem;
            margin: 2rem 0;
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .stat-item {
            text-align: center;
            color: white;
        }
        
        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            display: block;
        }
        
        .stat-label {
            font-size: 0.9rem;
            opacity: 0.8;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }
        
        .cta-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            min-width: 180px;
            justify-content: center;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }
        
        .cta-button.secondary {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
        }
        
        .cta-button.secondary:hover {
            box-shadow: 0 8px 25px rgba(76, 175, 80, 0.4);
        }
        
        .error-container {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            box-shadow: 0 8px 32px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
        }
        
        .error-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
        }
        
        .completion-summary {
            background: rgba(76, 175, 80, 0.1);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1rem;
            margin: 1rem 0;
            border: 1px solid rgba(76, 175, 80, 0.3);
            color: white;
            text-align: center;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% {
                transform: translateY(0);
            }
            40% {
                transform: translateY(-10px);
            }
            60% {
                transform: translateY(-5px);
            }
        }
        
        @keyframes pulse {
            0% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
            100% {
                transform: scale(1);
            }
        }
        
        @media (max-width: 768px) {
            .routine-container {
                padding: 1rem;
            }
            
            .routine-title {
                font-size: 2rem;
            }
            
            .exercise-card {
                padding: 1rem;
                flex-direction: column;
                text-align: center;
            }
            
            .exercise-icon {
                font-size: 2.5rem;
            }
            
            .stats-bar {
                flex-direction: column;
                gap: 1rem;
            }
            
            .action-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .cta-button {
                width: 100%;
                max-width: 300px;
            }
        }
    </style>";

    // Obtener el total de ejercicios para el JavaScript
    $total_ejercicios = count($ejercicios);

    // JavaScript para manejar la funcionalidad de completar ejercicios
    $javascript = "
    <script>
        let completedExercises = 0;
        const totalExercises = $total_ejercicios;
        
        function toggleExercise(button, exerciseIndex) {
            const card = button.closest('.exercise-card');
            const isCompleted = card.classList.contains('completed');
            
            if (isCompleted) {
                // Desmarcar como completado
                card.classList.remove('completed');
                button.textContent = 'Completar';
                button.classList.remove('completed');
                completedExercises--;
            } else {
                // Marcar como completado
                card.classList.add('completed');
                button.textContent = '✓ Hecho';
                button.classList.add('completed');
                completedExercises++;
            }
            
            updateCompletionSummary();
        }
        
        function updateCompletionSummary() {
            const summaryElement = document.getElementById('completion-summary');
            if (completedExercises === 0) {
                summaryElement.style.display = 'none';
            } else {
                summaryElement.style.display = 'block';
                const percentage = Math.round((completedExercises / totalExercises) * 100);
                summaryElement.innerHTML = `
                    <strong>Progreso de la rutina: \${completedExercises}/\${totalExercises} ejercicios (\${percentage}%)</strong><br>
                    \${completedExercises === totalExercises ? '🎉 ¡Rutina completada! ¡Excelente trabajo!' : '💪 ¡Sigue así, lo estás haciendo genial!'}
                `;
            }
        }
        
        function completeAllExercises() {
            const cards = document.querySelectorAll('.exercise-card:not(.completed)');
            cards.forEach((card, index) => {
                setTimeout(() => {
                    const button = card.querySelector('.complete-btn');
                    if (button && !button.classList.contains('completed')) {
                        toggleExercise(button, index);
                    }
                }, index * 200);
            });
        }
    </script>";

    // Generar HTML mejorado
    $html = $css . $javascript . "
    <div class='routine-container'>
        <div class='routine-header'>
            <h1 class='routine-title'>💪 Tu Rutina Personalizada</h1>
            <p class='routine-subtitle'>Diseñada especialmente para ti</p>
        </div>
        
        <div class='stats-bar'>
            <div class='stat-item'>
                <span class='stat-number'>" . count($ejercicios) . "</span>
                <span class='stat-label'>Ejercicios</span>
            </div>
            <div class='stat-item'>
                <span class='stat-number'>" . $eval['tiempo_disponible'] . "</span>
                <span class='stat-label'>Tiempo</span>
            </div>
            <div class='stat-item'>
                <span class='stat-number'>" . ucfirst($eval['objetivo']) . "</span>
                <span class='stat-label'>Objetivo</span>
            </div>
        </div>
        
        <div id='completion-summary' class='completion-summary' style='display: none;'></div>
        
        <div class='exercises-grid'>";

    foreach ($ejercicios as $index => $ejercicio) {
        $ejercicio = trim($ejercicio);
        $ejercicio_info = ["icon" => "🏃‍♂️", "color" => "#6366f1", "category" => "General"];
        
        // Buscar información del ejercicio
        foreach ($ejercicios_data as $clave => $datos) {
            if (stripos($ejercicio, $clave) !== false) {
                $ejercicio_info = $datos;
                break;
            }
        }
        
        $delay = ($index * 0.1) + 0.8;
        
        $html .= "
        <div class='exercise-card' style='--card-color: {$ejercicio_info['color']}; animation-delay: {$delay}s;'>
            <div class='exercise-icon'>{$ejercicio_info['icon']}</div>
            <div class='exercise-content'>
                <div class='exercise-name'>$ejercicio</div>
                <div class='exercise-category'>{$ejercicio_info['category']}</div>
            </div>
            <button class='complete-btn' onclick='toggleExercise(this, $index)'>Completar</button>
        </div>";
    }

    $html .= "
        </div>
        
        <div class='action-buttons'>
            <a href='progreso.php' class='cta-button'>
                📊 Ver Progreso
            </a>
            <button class='cta-button secondary' onclick='completeAllExercises()'>
                ✅ Completar Todo
            </button>
        </div>
        
        <div class='motivation-section'>
            <div class='motivation-icon'>🔥</div>
            <p class='motivation-text'>
                <strong>¡Es tu momento de brillar!</strong><br>
                Recuerda calentar antes de empezar y escucha a tu cuerpo. 
                Cada repetición te acerca más a tu mejor versión. 
                Si tienes dudas médicas, consulta con un profesional.
            </p>
        </div>
    </div>";

    return $html;
}

// MOSTRAR LA RUTINA PARA UN USUARIO (ID 1 como ejemplo)
$usuario_id = 4;
echo obtenerRutinaPersonalizada($usuario_id, $conexion);
?>