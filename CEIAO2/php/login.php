<?php
session_start();

// Verifica si el usuario ya está logueado, si es así, redirige al inicio
if (isset($_SESSION['user_id'])) {
    header("Location: ../index.php"); // Redirigir a la página principal en la raíz
    exit();
}

// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "cursos_dentistas");

// Verifica si la conexión falló
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Verifica si los datos del formulario están presentes
if (isset($_POST['email']) && isset($_POST['password'])) {
    // Obtener el email y la contraseña del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Buscar el usuario en la base de datos
    $sql = "SELECT id, name, email, password, role FROM users WHERE email = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $usuario['password'])) {
            // Iniciar sesión
            $_SESSION['user_id'] = $usuario['id'];  // Asegúrate de usar 'user_id'
            $_SESSION['user_name'] = $usuario['name'];
            $_SESSION['role'] = $usuario['role'];  // Almacenar el rol en la sesión

            // Redirigir al index.php o a un dashboard dependiendo del rol
            if ($_SESSION['role'] === 'admin') {
                header("Location: ../admin_dashboard.php"); // Si es admin, redirigir a su panel
            } else {
                header("Location: ../index.php"); // Si es usuario normal, redirigir a la página principal
            }
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: login.html?error=Contraseña incorrecta.");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: login.html?error=Usuario no encontrado.");
        exit();
    }

    $stmt->close();
} else {
    header("Location: login.html?error=Por favor, ingrese ambos campos.");
    exit();
}

$conexion->close();
?>
