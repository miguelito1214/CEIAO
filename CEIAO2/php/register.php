<?php
require 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validar que no haya campos vacíos
    if (empty($name) || empty($email) || empty($password)) {
        die("Todos los campos son obligatorios.");
    }

    // Encriptar la contraseña
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insertar usuario en la base de datos
    $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        $success_message = "¡Usuario registrado exitosamente!";
    } else {
        $error_message = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Registro</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background-color: #003366; /* Azul fuerte */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .confirmation-container {
            background-color: #fff;
            padding: 2rem;
            width: 90%;
            max-width: 500px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .confirmation-container h2 {
            font-size: 2rem;
            color: #ffcc00; /* Título amarillo */
            margin-bottom: 1rem;
        }

        .confirmation-container p {
            font-size: 1.1rem;
            color: #333;
            margin-bottom: 1.5rem;
        }

        .confirmation-container a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .confirmation-container a:hover {
            text-decoration: underline;
        }

        .success-icon {
            font-size: 5rem;
            color: #28a745;
            margin-bottom: 1rem;
        }

        .error-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .button-container {
            margin-top: 2rem;
        }

        .btn {
            padding: 0.8rem 1.5rem;
            font-size: 1rem;
            color: white;
            background-color: #ffcc00; /* Botón amarillo */
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #ff9900;
        }
    </style>
</head>
<body>

    <div class="confirmation-container">
        <?php if (isset($success_message)): ?>
            <div class="success-icon">✔️</div>
            <h2><?php echo $success_message; ?></h2>
            <p>Tu cuenta se ha registrado correctamente. Ahora puedes iniciar sesión.</p>
            <div class="button-container">
                <a href="../login.html" class="btn">Iniciar sesión</a>
            </div>
        <?php elseif (isset($error_message)): ?>
            <div class="error-icon">❌</div>
            <h2>Error al registrar</h2>
            <p><?php echo $error_message; ?></p>
            <div class="button-container">
                <a href="javascript:history.back()" class="btn">Intentar nuevamente</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>
