<?php
session_start();
require_once 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Función para evaluar salud
function evaluarEstadoSalud($datos) {
    $riesgo = 0;

    switch ($datos['frecuencia_ejercicio']) {
        case '0': $riesgo += 2; break;
        case '1-2': $riesgo += 1; break;
        case '3-4': break;
        case '5+': $riesgo -= 1; break;
    }

    if ($datos['horas_sentado'] === '>8') $riesgo += 2;
    elseif ($datos['horas_sentado'] === '4-8') $riesgo += 1;

    if ($datos['fumas'] === 'frecuentemente') $riesgo += 2;
    if ($datos['alcohol'] === 'frecuentemente') $riesgo += 1;

    if (!empty($datos['condiciones_medicas'])) $riesgo += 2;
    if (!empty($datos['lesiones'])) $riesgo += 1;

    if ($datos['frutas_verduras'] === 'siempre') $riesgo -= 1;
    elseif ($datos['frutas_verduras'] === 'nunca') $riesgo += 1;

    if ($riesgo >= 5) return "salud en riesgo";
    if ($riesgo >= 3) return "sedentario";
    if ($riesgo == 2) return "actividad moderada con observación";
    if ($riesgo <= 1) return "activo saludable";

    return "evaluación indefinida";
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datos = [
        'frecuencia_ejercicio' => $_POST['frecuencia_ejercicio'],
        'horas_sentado' => $_POST['horas_sentado'],
        'frutas_verduras' => $_POST['frutas_verduras'],
        'restricciones_alimentarias' => $_POST['restricciones_alimentarias'],
        'objetivo' => $_POST['objetivo'],
        'condiciones_medicas' => $_POST['condiciones_medicas'],
        'lesiones' => $_POST['lesiones'],
        'fumas' => $_POST['fumas'],
        'alcohol' => $_POST['alcohol'],
        'tiempo_disponible' => $_POST['tiempo_disponible'],
        'tipo_ejercicio_preferido' => $_POST['tipo_ejercicio_preferido'],
        'dias_disponibles' => isset($_POST['dias_disponibles']) ? $_POST['dias_disponibles'] : []
    ];

    $estado_salud = evaluarEstadoSalud($datos);

    $stmt = $conn->prepare("INSERT INTO evaluaciones 
        (usuario_id, estado_salud, objetivo, tiempo_disponible, tipo_ejercicio_preferido, restricciones_alimentarias, dias_disponibles)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    
    $dias = implode(",", $datos['dias_disponibles']);
    $stmt->bind_param(
        "issssss",
        $_SESSION['usuario_id'],
        $estado_salud,
        $datos['objetivo'],
        $datos['tiempo_disponible'],
        $datos['tipo_ejercicio_preferido'],
        $datos['restricciones_alimentarias'],
        $dias
    );
    $stmt->execute();

    echo "<script>alert('Evaluación guardada con éxito.'); window.location='panel.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluación Inicial - FitAssistant</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border: none;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(to right, #4b6cb7, #182848);
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 1.5rem;
        }
        .form-section {
            margin-bottom: 2rem;
            padding: 1.5rem;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }
        .form-section h5 {
            color: #4b6cb7;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 0.5rem;
        }
        .btn-submit {
            background: linear-gradient(to right, #4b6cb7, #182848);
            border: none;
            padding: 10px 25px;
            font-weight: bold;
            letter-spacing: 1px;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .form-check-label {
            cursor: pointer;
        }
        .form-control, .form-select {
            border-radius: 8px;
            padding: 10px 15px;
            border: 1px solid #ddd;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4b6cb7;
            box-shadow: 0 0 0 0.25rem rgba(75, 108, 183, 0.25);
        }
        .health-icon {
            font-size: 1.5rem;
            margin-right: 10px;
            color: #4b6cb7;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card animate__animated animate__fadeInUp">
                    <div class="card-header">
                        <h3><i class="fas fa-heartbeat me-2"></i> Evaluación Inicial - FitAssistant</h3>
                        <p class="mb-0">Completa este formulario para recibir tu plan personalizado</p>
                    </div>
                    <div class="card-body">
                        <form method="POST" class="needs-validation" novalidate>
                            <!-- Sección Actividad Física -->
                            <div class="form-section animate__animated animate__fadeIn">
                                <h5><i class="fas fa-running health-icon"></i> Actividad Física</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Cuántas veces haces ejercicio a la semana?</label>
                                        <select class="form-select" name="frecuencia_ejercicio" required>
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="0">Nunca</option>
                                            <option value="1-2">1-2 veces</option>
                                            <option value="3-4">3-4 veces</option>
                                            <option value="5+">5 o más</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Cuántas horas pasas sentado al día?</label>
                                        <select class="form-select" name="horas_sentado" required>
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="<4">Menos de 4</option>
                                            <option value="4-8">4 a 8 horas</option>
                                            <option value=">8">Más de 8 horas</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Hábitos Alimenticios -->
                            <div class="form-section animate__animated animate__fadeIn animate__delay-1s">
                                <h5><i class="fas fa-utensils health-icon"></i> Hábitos Alimenticios</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Qué tan frecuentemente comes frutas y verduras?</label>
                                        <select class="form-select" name="frutas_verduras" required>
                                            <option value="" selected disabled>Selecciona una opción</option>
                                            <option value="nunca">Nunca</option>
                                            <option value="a veces">A veces</option>
                                            <option value="frecuente">Frecuentemente</option>
                                            <option value="siempre">Siempre</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Tienes alguna restricción alimentaria?</label>
                                        <select class="form-select" name="restricciones_alimentarias">
                                            <option value="ninguna">Ninguna</option>
                                            <option value="vegetariana">Vegetariana</option>
                                            <option value="vegana">Vegana</option>
                                            <option value="sin gluten">Sin gluten</option>
                                            <option value="sin lactosa">Sin lactosa</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Salud -->
                            <div class="form-section animate__animated animate__fadeIn animate__delay-2s">
                                <h5><i class="fas fa-heart health-icon"></i> Salud</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Tienes alguna condición médica?</label>
                                        <select class="form-select" name="condiciones_medicas">
                                            <option value="ninguna">Ninguna</option>
                                            <option value="hipertensión">Hipertensión</option>
                                            <option value="diabetes">Diabetes</option>
                                            <option value="asma">Asma</option>
                                            <option value="problemas cardíacos">Problemas cardíacos</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Has sufrido lesiones recientemente?</label>
                                        <select class="form-select" name="lesiones">
                                            <option value="ninguna">Ninguna</option>
                                            <option value="rodilla">Rodilla</option>
                                            <option value="espalda">Espalda</option>
                                            <option value="hombro">Hombro</option>
                                            <option value="otra">Otra</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Hábitos -->
                            <div class="form-section animate__animated animate__fadeIn animate__delay-3s">
                                <h5><i class="fas fa-smoking health-icon"></i> Hábitos</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Fumas?</label>
                                        <select class="form-select" name="fumas">
                                            <option value="no">No</option>
                                            <option value="ocasionalmente">Ocasionalmente</option>
                                            <option value="frecuentemente">Frecuentemente</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Consumes alcohol?</label>
                                        <select class="form-select" name="alcohol">
                                            <option value="no">No</option>
                                            <option value="ocasionalmente">Ocasionalmente</option>
                                            <option value="frecuentemente">Frecuentemente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Objetivos -->
                            <div class="form-section animate__animated animate__fadeIn animate__delay-4s">
                                <h5><i class="fas fa-bullseye health-icon"></i> Objetivos</h5>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Cuál es tu objetivo principal?</label>
                                        <select class="form-select" name="objetivo" required>
                                            <option value="" selected disabled>Selecciona tu objetivo</option>
                                            <option value="bajar peso">Bajar de peso</option>
                                            <option value="aumentar músculo">Aumentar músculo</option>
                                            <option value="mantenerse">Mantenerse</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label">¿Cuánto tiempo puedes dedicar al ejercicio cada día?</label>
                                        <select class="form-select" name="tiempo_disponible">
                                            <option value="<30 min">Menos de 30 min</option>
                                            <option value="30-60 min">30-60 min</option>
                                            <option value=">60 min">Más de 60 min</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label class="form-label">¿Qué tipo de ejercicios prefieres?</label>
                                        <select class="form-select" name="tipo_ejercicio_preferido">
                                            <option value="cardio">Cardio</option>
                                            <option value="fuerza">Fuerza</option>
                                            <option value="flexibilidad">Flexibilidad</option>
                                            <option value="resistencia">Resistencia</option>
                                            <option value="yoga/pilates">Yoga / Pilates</option>
                                            <option value="combinado">Combinado</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección Disponibilidad -->
                            <div class="form-section animate__animated animate__fadeIn animate__delay-5s">
                                <h5><i class="far fa-calendar-alt health-icon"></i> Disponibilidad</h5>
                                <div class="mb-3">
                                    <label class="form-label">¿Qué días puedes entrenar?</label>
                                    <div class="row">
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="lunes" id="lunes">
                                                <label class="form-check-label" for="lunes">Lunes</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="martes" id="martes">
                                                <label class="form-check-label" for="martes">Martes</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="miércoles" id="miercoles">
                                                <label class="form-check-label" for="miercoles">Miércoles</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="jueves" id="jueves">
                                                <label class="form-check-label" for="jueves">Jueves</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="viernes" id="viernes">
                                                <label class="form-check-label" for="viernes">Viernes</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="sábado" id="sabado">
                                                <label class="form-check-label" for="sabado">Sábado</label>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-3 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dias_disponibles[]" value="domingo" id="domingo">
                                                <label class="form-check-label" for="domingo">Domingo</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary btn-submit animate__animated animate__pulse animate__infinite">
                                    <i class="fas fa-check-circle me-2"></i> Generar Mi Plan Personalizado
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación de formulario
        (function () {
            'use strict'
            
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        
                        form.classList.add('was-validated')
                    }, false)
                })
        })()
    </script>
</body>
</html>