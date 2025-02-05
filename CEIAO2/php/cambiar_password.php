<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cursos_dentistas");

// Obtén los datos del formulario
$password_actual = $_POST['password_actual'];
$password_nueva = $_POST['password_nueva'];
$password_confirmar = $_POST['password_confirmar'];
$usuario_id = $_SESSION['user_id'];  // Cambiar a 'user_id'

// Verifica si las contraseñas nuevas coinciden
if ($password_nueva !== $password_confirmar) {
    die("Las contraseñas no coinciden.");
}

// Obtén la contraseña actual del usuario
$sql = "SELECT password FROM users WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Verifica si la contraseña actual es correcta
if (!password_verify($password_actual, $usuario['password'])) {
    die("La contraseña actual es incorrecta.");
}

// Actualiza la contraseña
$password_hash = password_hash($password_nueva, PASSWORD_BCRYPT);
$sql = "UPDATE users SET password = ? WHERE id = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("si", $password_hash, $usuario_id);
if ($stmt->execute()) {
    echo "Contraseña cambiada con éxito.";
} else {
    echo "Error al cambiar la contraseña.";
}
?>
