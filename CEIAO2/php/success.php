<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Exitosa</title>
</head>
<body>

<h2>¡Compra realizada con éxito!</h2>
<p>Tu curso ha sido agregado a tu cuenta.</p>
<a href="courses.php">Ir a mis cursos</a>

</body>
</html>
