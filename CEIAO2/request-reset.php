<?php
// Incluir los archivos de PHPMailer
require 'lib/PHPMailer/PHPMailer.php';
require 'lib/PHPMailer/SMTP.php';
require 'lib/PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configuración de la conexión a la base de datos
$pdo = new PDO('mysql:host=localhost;dbname=nombre_db', 'usuario', 'contraseña');

// Si el formulario es enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verificar si el correo electrónico está registrado
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        // Generar un token único
        $token = bin2hex(random_bytes(32)); // Generar un token aleatorio
        $expiry = date('Y-m-d H:i:s', strtotime('+1 hour')); // El token expirará en 1 hora

        // Guardar el token en la base de datos
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token, token_expiry = :expiry WHERE email = :email");
        $stmt->execute(['token' => $token, 'expiry' => $expiry, 'email' => $email]);

        // Enviar el correo con el enlace de restablecimiento
        sendResetEmail($email, $token);

        echo "Te hemos enviado un enlace para restablecer tu contraseña.";
    } else {
        echo "No encontramos una cuenta con ese correo electrónico.";
    }
}

// Función para enviar el correo de restablecimiento
function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);
    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';  // Reemplaza con tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@example.com';  // Tu correo electrónico
        $mail->Password = 'your-email-password';  // Tu contraseña
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remitente y destinatario
        $mail->setFrom('your-email@example.com', 'Tu Nombre');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Restablecer Contraseña';
        $mail->Body    = 'Haz clic en el siguiente enlace para restablecer tu contraseña: 
                         <a href="http://tudominio.com/reset-password.php?token=' . $token . '">Restablecer Contraseña</a>';

        // Enviar el correo
        $mail->send();
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de correo: {$mail->ErrorInfo}";
    }
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
    <h2>Solicitar Restablecimiento de Contraseña</h2>
    <form action="request-reset.php" method="post">
        <label for="email">Correo electrónico:</label>
        <input type="email" name="email" required>
        <button type="submit">Solicitar Restablecimiento</button>
    </form>
</body>
</html>

