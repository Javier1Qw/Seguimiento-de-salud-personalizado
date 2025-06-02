<?php
session_start();
require_once '../conexion.php'; // Archivo que conecta a la base de datos (creamos después)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    if (!$correo || !$contrasena) {
        // Falta algún dato
        header('Location: ../login.php?error=Datos incompletos');
        exit();
    }

    // Preparar consulta para evitar SQL Injection
    $stmt = $conn->prepare("SELECT id, nombre, correo, contrasena FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        // Verificar contraseña con password_verify
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Inicio de sesión correcto
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];
            $_SESSION['usuario_correo'] = $usuario['correo'];

            // Redirigir al panel
            header('Location: ../panel.php');
            exit();
        } else {
            header('Location: ../login.php?error=Contraseña incorrecta');
            exit();
        }
    } else {
        header('Location: ../login.php?error=Usuario no encontrado');
        exit();
    }
} else {
    // Si acceden sin POST
    header('Location: ../login.php');
    exit();
}
