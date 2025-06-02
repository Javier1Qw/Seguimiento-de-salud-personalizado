<?php
// dieta_perso.php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "assit_fit");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Función para obtener datos del usuario o evaluación desde la base de datos
function obtenerEvaluacionUsuario($usuario_id, $conexion) {
    $sql = "SELECT estado_salud, objetivo FROM evaluaciones WHERE usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    if ($resultado->num_rows === 0) {
        return null;
    }
    return $resultado->fetch_assoc();
}

// Función para generar recomendación de dieta con estilos mejorados
function obtenerRecomendacionDieta($eval) {
    if (!$eval) {
        return "
        <div class='diet-container'>
            <div class='error-section'>
                <div class='error-icon'>📋</div>
                <h3>Evaluación Requerida</h3>
                <p>Necesitas completar tu evaluación nutricional para recibir tu plan personalizado.</p>
                <button class='cta-button'>Completar Evaluación</button>
            </div>
        </div>";
    }

    $estado_salud = $eval['estado_salud'];
    $objetivo = strtolower($eval['objetivo']);
    
    // Datos nutricionales mejorados por objetivo
    $planes_nutricionales = [
        'perder_peso' => [
            'titulo' => 'Plan de Pérdida de Peso',
            'subtitulo' => 'Déficit calórico inteligente',
            'color_primario' => '#FF6B6B',
            'color_secundario' => '#FFE66D',
            'icono' => '🔥',
            'macros' => ['Proteína: 30%', 'Carbohidratos: 35%', 'Grasas: 35%'],
            'alimentos' => [
                ['nombre' => 'Verduras de hoja verde', 'beneficio' => 'Bajas en calorías, altas en nutrientes', 'icono' => '🥬'],
                ['nombre' => 'Proteínas magras', 'beneficio' => 'Mantienen la masa muscular', 'icono' => '🐟'],
                ['nombre' => 'Frutas bajas en azúcar', 'beneficio' => 'Fibra y antioxidantes', 'icono' => '🫐'],
                ['nombre' => 'Granos integrales', 'beneficio' => 'Energía sostenida', 'icono' => '🌾'],
                ['nombre' => 'Agua abundante', 'beneficio' => 'Hidratación y saciedad', 'icono' => '💧']
            ],
            'evitar' => ['Azúcares refinados', 'Comida procesada', 'Frituras', 'Bebidas azucaradas']
        ],
        'ganar_musculo' => [
            'titulo' => 'Plan de Construcción Muscular',
            'subtitulo' => 'Superávit calórico estratégico',
            'color_primario' => '#4ECDC4',
            'color_secundario' => '#45B7B8',
            'icono' => '💪',
            'macros' => ['Proteína: 35%', 'Carbohidratos: 45%', 'Grasas: 20%'],
            'alimentos' => [
                ['nombre' => 'Proteínas completas', 'beneficio' => 'Construcción muscular óptima', 'icono' => '🥩'],
                ['nombre' => 'Carbohidratos complejos', 'beneficio' => 'Energía para entrenamientos', 'icono' => '🍠'],
                ['nombre' => 'Grasas saludables', 'beneficio' => 'Hormonas anabólicas', 'icono' => '🥑'],
                ['nombre' => 'Lácteos', 'beneficio' => 'Proteína de suero natural', 'icono' => '🥛'],
                ['nombre' => 'Frutos secos', 'beneficio' => 'Calorías densas y nutrientes', 'icono' => '🥜']
            ],
            'evitar' => ['Alcohol excesivo', 'Azúcares simples', 'Comida chatarra', 'Ayunos prolongados']
        ],
        'mantenimiento' => [
            'titulo' => 'Plan de Mantenimiento',
            'subtitulo' => 'Balance nutricional perfecto',
            'color_primario' => '#A8E6CF',
            'color_secundario' => '#88D8A3',
            'icono' => '⚖️',
            'macros' => ['Proteína: 25%', 'Carbohidratos: 45%', 'Grasas: 30%'],
            'alimentos' => [
                ['nombre' => 'Variedad de vegetales', 'beneficio' => 'Micronutrientes diversos', 'icono' => '🥕'],
                ['nombre' => 'Proteínas variadas', 'beneficio' => 'Perfil aminoácido completo', 'icono' => '🍗'],
                ['nombre' => 'Granos enteros', 'beneficio' => 'Fibra y energía estable', 'icono' => '🌾'],
                ['nombre' => 'Frutas de temporada', 'beneficio' => 'Antioxidantes naturales', 'icono' => '🍎'],
                ['nombre' => 'Aceites naturales', 'beneficio' => 'Vitaminas liposolubles', 'icono' => '🫒']
            ],
            'evitar' => ['Excesos de cualquier tipo', 'Comida ultra-procesada', 'Sedentarismo', 'Estrés alimentario']
        ]
    ];

    // Determinar plan según objetivo
    $plan_key = 'mantenimiento';
    if (strpos($objetivo, 'bajar') !== false || strpos($objetivo, 'perder') !== false) {
        $plan_key = 'perder_peso';
    } elseif (strpos($objetivo, 'ganar') !== false || strpos($objetivo, 'músculo') !== false) {
        $plan_key = 'ganar_musculo';
    }

    $plan = $planes_nutricionales[$plan_key];

    // CSS mejorado para dietas
    $css = "
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        .diet-container {
            font-family: 'Poppins', sans-serif;
            max-width: 900px;
            margin: 0 auto;
            padding: 2rem;
            background: linear-gradient(135deg, {$plan['color_primario']} 0%, {$plan['color_secundario']} 100%);
            min-height: 100vh;
            position: relative;
            overflow: hidden;
        }
        
        .diet-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns=\"http://www.w3.org/2000/svg\" viewBox=\"0 0 60 60\"><defs><pattern id=\"dots\" width=\"20\" height=\"20\" patternUnits=\"userSpaceOnUse\"><circle cx=\"10\" cy=\"10\" r=\"1\" fill=\"%23ffffff\" opacity=\"0.1\"/></pattern></defs><rect width=\"60\" height=\"60\" fill=\"url(%23dots)\"/></svg>');
            pointer-events: none;
        }
        
        .diet-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
            z-index: 1;
        }
        
        .diet-title {
            font-size: 3.5rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: slideInDown 0.8s ease-out;
        }
        
        .diet-subtitle {
            font-size: 1.3rem;
            color: rgba(255,255,255,0.95);
            font-weight: 400;
            animation: slideInDown 0.8s ease-out 0.2s both;
        }
        
        .macros-overview {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin: 2rem 0;
            animation: fadeInUp 0.8s ease-out 0.4s both;
        }
        
        .macro-card {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(20px);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.3);
            transition: all 0.3s ease;
        }
        
        .macro-card:hover {
            transform: translateY(-5px);
            background: rgba(255,255,255,0.3);
        }
        
        .macro-text {
            color: white;
            font-weight: 600;
            font-size: 1.1rem;
        }
        
        .foods-section {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 2.5rem;
            margin: 2rem 0;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            border: 1px solid rgba(255,255,255,0.2);
            animation: fadeInUp 0.8s ease-out 0.6s both;
        }
        
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #2d3748;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .foods-grid {
            display: grid;
            gap: 1.5rem;
            margin-bottom: 2rem;
        }
        
        .food-item {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            padding: 1.5rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid {$plan['color_primario']};
        }
        
        .food-item:hover {
            transform: translateX(10px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        
        .food-icon {
            font-size: 2.5rem;
            filter: drop-shadow(0 2px 4px rgba(0,0,0,0.1));
        }
        
        .food-content {
            flex: 1;
        }
        
        .food-name {
            font-size: 1.3rem;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }
        
        .food-benefit {
            color: #64748b;
            font-size: 1rem;
            line-height: 1.4;
        }
        
        .avoid-section {
            background: linear-gradient(135deg, #fef7f0 0%, #fed7aa 100%);
            border-radius: 15px;
            padding: 2rem;
            margin-top: 2rem;
            border-left: 4px solid #fb923c;
        }
        
        .avoid-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #c2410c;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .avoid-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 0.5rem;
        }
        
        .avoid-item {
            color: #9a3412;
            font-weight: 500;
            padding: 0.5rem;
            background: rgba(255,255,255,0.7);
            border-radius: 8px;
            text-align: center;
        }
        
        .tips-section {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            margin-top: 2rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            animation: fadeInUp 0.8s ease-out 0.8s both;
        }
        
        .tips-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            animation: float 3s ease-in-out infinite;
        }
        
        .tips-text {
            color: white;
            font-size: 1.1rem;
            line-height: 1.6;
            font-weight: 400;
        }
        
        .error-section {
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
        
        .cta-button {
            background: linear-gradient(135deg, {$plan['color_primario']} 0%, {$plan['color_secundario']} 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 1rem;
        }
        
        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba({$plan['color_primario']}, 0.4);
        }
        
        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
        
        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-10px);
            }
        }
        
        @media (max-width: 768px) {
            .diet-container {
                padding: 1rem;
            }
            
            .diet-title {
                font-size: 2.5rem;
            }
            
            .foods-section {
                padding: 1.5rem;
            }
            
            .food-item {
                padding: 1rem;
            }
            
            .macros-overview {
                grid-template-columns: 1fr;
            }
        }
    </style>";

    // Generar HTML mejorado
    $html = $css . "
    <div class='diet-container'>
        <div class='diet-header'>
            <h1 class='diet-title'>{$plan['icono']} {$plan['titulo']}</h1>
            <p class='diet-subtitle'>{$plan['subtitulo']}</p>
        </div>
        
        <div class='macros-overview'>";
    
    foreach ($plan['macros'] as $macro) {
        $html .= "
        <div class='macro-card'>
            <div class='macro-text'>$macro</div>
        </div>";
    }
    
    $html .= "
        </div>
        
        <div class='foods-section'>
            <h2 class='section-title'>🌟 Alimentos Recomendados</h2>
            <div class='foods-grid'>";
    
    foreach ($plan['alimentos'] as $alimento) {
        $html .= "
        <div class='food-item'>
            <div class='food-icon'>{$alimento['icono']}</div>
            <div class='food-content'>
                <div class='food-name'>{$alimento['nombre']}</div>
                <div class='food-benefit'>{$alimento['beneficio']}</div>
            </div>
        </div>";
    }
    
    $html .= "
            </div>
            
            <div class='avoid-section'>
                <h3 class='avoid-title'>⚠️ Alimentos a Limitar</h3>
                <div class='avoid-list'>";
    
    foreach ($plan['evitar'] as $evitar) {
        $html .= "<div class='avoid-item'>$evitar</div>";
    }
    
    $html .= "
                </div>
            </div>
        </div>
        
        <div class='tips-section'>
            <div class='tips-icon'>💡</div>
            <p class='tips-text'>
                <strong>¡Tu éxito nutricional es nuestro objetivo!</strong><br>
                Recuerda que la consistencia es clave. Adapta las porciones según tu actividad física 
                y consulta con un nutricionista profesional para ajustes específicos a tu salud.
                <br><br>
                <em>La alimentación consciente es el primer paso hacia tu transformación.</em>
            </p>
        </div>
    </div>";

    return $html;
}

// Obtener el id del usuario desde GET o definirlo fijo para pruebas
$usuario_id = isset($_GET['usuario_id']) ? intval($_GET['usuario_id']) : 1;

// Obtener evaluación
$evaluacion = obtenerEvaluacionUsuario($usuario_id, $conexion);

// Mostrar la recomendación
echo obtenerRecomendacionDieta($evaluacion);
?>