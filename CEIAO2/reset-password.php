<?php
// Incluir los archivos de PHPMailer
require 'lib/PHPMailer/PHPMailer.php';
require 'lib/PHPMailer/SMTP.php';
require 'lib/PHPMailer/Exception.php';

// Conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=nombre_db', 'usuario', 'contraseña');

// Obtener el token de la URL
$token = $_GET['token'];

// Verificar si el token es válido
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = :token AND token_expiry > NOW()");
$stmt->execute(['token' => $token]);
$user = $stmt->fetch();

if ($user) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos y limpiar el token
        $stmt = $pdo->prepare("UPDATE users SET password = :password, reset_token = NULL, token_expiry = NULL WHERE id = :id");
        $stmt->execute(['password' => $new_password, 'id' => $user['id']]);

        echo "Contraseña actualizada exitosamente.";
    }
} else {
    echo "El token es inválido o ha expirado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
</head>
<body>
    <h2>Restablecer Contraseña</h2>
    <form action="reset-password.php?token=<?php echo $token; ?>" method="post">
        <label for="new_password">Nueva Contraseña:</label>
        <input type="password" name="new_password" required>
        <button type="submit">Actualizar Contraseña</button>
    </form>
</body>
</html>
