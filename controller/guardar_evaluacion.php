<?php
session_start();
require_once '../conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    die("Acceso no autorizado.");
}

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
        'dias_disponibles' => isset($_POST['dias_disponibles']) ? implode(",", $_POST['dias_disponibles']) : ""
    ];

    $estado_salud = evaluarEstadoSalud($datos);

    $stmt = $conn->prepare("INSERT INTO evaluaciones 
        (usuario_id, estado_salud, objetivo, tiempo_disponible, tipo_ejercicio_preferido, restricciones_alimentarias, dias_disponibles) 
        VALUES (?, ?, ?, ?, ?, ?, ?)");

    $stmt->bind_param(
        "issssss",
        $_SESSION['usuario_id'],
        $estado_salud,
        $datos['objetivo'],
        $datos['tiempo_disponible'],
        $datos['tipo_ejercicio_preferido'],
        $datos['restricciones_alimentarias'],
        $datos['dias_disponibles']
    );

    if ($stmt->execute()) {
        header("Location: ../panel.php?mensaje=Evaluación guardada");
    } else {
        echo "Error al guardar evaluación: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
