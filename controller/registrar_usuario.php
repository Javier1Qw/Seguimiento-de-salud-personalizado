<?php
session_start();
require_once '../conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = trim($_POST['nombre']);
    $correo = trim($_POST['correo']);
    $contrasena = $_POST['contrasena'];
    $edad = intval($_POST['edad']);
    $sexo = $_POST['sexo'];
    $peso = floatval($_POST['peso']);
    $estatura = floatval($_POST['estatura']);

    // Validar email
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Correo no válido.'); window.location='../registro.php';</script>";
        exit();
    }

    // Verificar si ya existe el correo
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('Este correo ya está registrado.'); window.location='../registro.php';</script>";
        $stmt->close();
        exit();
    }
    $stmt->close();

    // Hashear la contraseña
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Insertar usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena, edad, sexo, peso, estatura) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssissd", $nombre, $correo, $hash, $edad, $sexo, $peso, $estatura);
    $stmt->execute();

    // Obtener el ID insertado
    $usuario_id = $stmt->insert_id;
    $_SESSION['usuario_id'] = $usuario_id;
    $_SESSION['nombre'] = $nombre;

    $stmt->close();

    // Redirigir a evaluación inicial
    header("Location: ../evaluacion_inicial.php");
    exit();
} else {
    header("Location: ../registro.php");
    exit();
}
