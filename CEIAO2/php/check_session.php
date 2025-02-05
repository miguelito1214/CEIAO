<?php
session_start();

// Si el usuario está autenticado, redirigir a la página de cursos
if (isset($_SESSION['user_id'])) {
    header("Location: ../courses.php");
    exit();
}

// Si no está autenticado, redirigir al formulario de inicio de sesión
header("Location: ../login.html");
exit();
?>
