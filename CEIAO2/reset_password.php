<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('php/connection.php'); // Incluir conexión

if (isset($_GET['token'])) {
    $reset_token = $_GET['token'];

    // Verificar si el token es válido y no ha expirado
    $stmt = $conn->prepare("SELECT * FROM users WHERE reset_token = ? AND reset_token_expiry > NOW()");
    $stmt->bind_param("s", $reset_token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // El token es válido, permitir cambiar la contraseña
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Obtener la nueva contraseña
            $new_password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE reset_token = ?");
            $stmt->bind_param("ss", $new_password, $reset_token);
            $stmt->execute();

            echo "Tu contraseña ha sido restablecida exitosamente.";
        }
    } else {
        echo "El enlace de restablecimiento es inválido o ha expirado.";
    }
}
?>

<!-- Formulario para ingresar la nueva contraseña -->
<form method="POST">
    <label for="password">Nueva Contraseña:</label>
    <input type="password" name="password" required>
    <button type="submit">Restablecer Contraseña</button>
</form>
