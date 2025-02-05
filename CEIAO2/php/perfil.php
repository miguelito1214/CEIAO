<?php
session_start();

// Verifica si el usuario está logueado
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cursos_dentistas");

// Verifica si la conexión falló
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Obtén los datos del usuario
$usuario_id = $_SESSION['user_id'];  // Cambiar a 'user_id'
$sql = "SELECT name AS nombre, email AS correo FROM users WHERE id = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();

    if (!$usuario) {
        echo "Error: No se encontraron datos del usuario.";
        exit;
    }

    $stmt->close();
} else {
    echo "Error en la consulta: " . $conexion->error;
    exit;
}

$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: linear-gradient(to bottom, #003366, #005599);
        }

        header {
            background-color: #003366;
            color: white;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        .navbar {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 1200px;
        }

        .logo img {
            height: 50px;
            margin-right: 2rem;
        }

        .nav-links {
            list-style: none;
            display: flex;
            gap: 2rem;
            justify-content: center;
        }

        .nav-links li {
            display: inline;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #FFCC00;
        }

        footer {
            background-color: #003366;
            color: white;
            padding: 1rem;
            text-align: center;
            margin-top: auto;
        }

        .container {
            display: flex;
            flex: 1;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        h1 {
            color: #003366;
            margin-bottom: 1rem;
        }

        .profile-info {
            background-color: #ffffff;
            border-radius: 10px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .profile-info p {
            margin: 1rem 0;
            font-size: 1.1rem;
            color: #333;
        }

        .change-password-form {
            width: 100%;
            max-width: 500px;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 2rem;
        }

        .change-password-form label {
            display: block;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .change-password-form input {
            width: 100%;
            padding: 0.8rem;
            margin-bottom: 1rem;
            border-radius: 10px;
            border: 1px solid #ddd;
            font-size: 1rem;
        }

        .change-password-form button {
            background-color: #FFCC00;
            color: white;
            padding: 0.8rem;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            border: none;
            font-size: 1rem;
        }

        .change-password-form button:hover {
            background-color: #e6b800;
        }
    </style>
</head>

<body>
    <header class="main-header">
        <nav class="navbar">
        <div class="logo">
                        <img src="./assets/logo.jpg" alt="Logo">
                    </div>
            <ul class="nav-links">
                <li><a href="../index.php">Inicio</a></li>
                <li><a href="courses.php">Cursos</a></li>
                <li><a href="diplomados.php">Diplomados</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="profile-info">
            <h1>Mi Perfil</h1>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($usuario['nombre']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($usuario['correo']); ?></p>
        </div>

        <div class="change-password-form">
            <h2>Cambiar Contraseña</h2>
            <form action="cambiar_password.php" method="POST">
                <label for="password_actual">Contraseña Actual:</label>
                <input type="password" name="password_actual" id="password_actual" required><br>

                <label for="password_nueva">Nueva Contraseña:</label>
                <input type="password" name="password_nueva" id="password_nueva" required pattern=".{8,}" title="Debe tener al menos 8 caracteres"><br>

                <label for="password_confirmar">Confirmar Nueva Contraseña:</label>
                <input type="password" name="password_confirmar" id="password_confirmar" required pattern=".{8,}" title="Debe tener al menos 8 caracteres"><br>

                <button type="submit">Cambiar Contraseña</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; CEIAO | Diplomados Dentales y Consulta Especializada ®2024 Todos los Derechos Reservados</p>
    </footer>
</body>
</html>
