<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('php/connection.php'); // Incluir conexión

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el correo electrónico del formulario
    $email = $_POST['email'];

    // Verificar si el correo electrónico existe en la base de datos
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Si el usuario existe
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Generar un token de restablecimiento único (usando un hash)
        $reset_token = bin2hex(random_bytes(32)); // Genera un token de 64 caracteres
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour')); // Expiración del token dentro de 1 hora

        // Guardar el token en la base de datos
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = ? WHERE email = ?");
        $stmt->bind_param("sss", $reset_token, $expiry, $email);
        $stmt->execute();

        // Enviar el enlace de restablecimiento por correo electrónico
        $reset_link = "http://localhost/CEIAO2/reset_password.php?token=" . $reset_token;
        
        // Aquí puedes usar la función mail() de PHP para enviar el correo
        // Recuerda que para pruebas locales necesitarás configurar un servidor de correo como XAMPP o PHPMailer
        $subject = "Restablecer tu contraseña";
        $message = "Haga clic en el siguiente enlace para restablecer tu contraseña: " . $reset_link;
        $headers = "From: no-reply@tuempresa.com";
        
        // Si se envió el correo correctamente, puedes mostrar un mensaje
        if (mail($email, $subject, $message, $headers)) {
            echo "Hemos enviado un enlace para restablecer tu contraseña a tu correo electrónico.";
        } else {
            echo "Hubo un problema al enviar el correo. Intenta nuevamente.";
        }
    } else {
        echo "El correo electrónico ingresado no está registrado.";
    }
}
?>
