<?php
session_start();
include 'db.php'; // Conexión a la base de datos

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];
$diplomado_id = $_GET['id'] ?? null;

// Verificar que el ID del diplomado sea válido
if (!$diplomado_id) {
    header("Location: diplomados.php");
    exit();
}

// Verificar si el usuario ha pagado este diplomado
$query = "SELECT * FROM pagos WHERE user_id = ? AND course_id = ? AND estado = 'pagado'";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $diplomado_id);
$stmt->execute();
$result = $stmt->get_result();
$pagado = $result->num_rows > 0;
$stmt->close();

// Si no ha pagado, redirigirlo a la página de diplomados
if (!$pagado) {
    header("Location: diplomados.php");
    exit();
}

// Obtener la información del diplomado desde la base de datos (simulado aquí)
$diplomados = [
    1 => ["title" => "Diplomado en Ortodoncia", "content" => "Este es el contenido completo del diplomado en Ortodoncia."],
    2 => ["title" => "Diplomado en Cirugía Dental", "content" => "Aquí tienes acceso al material de Cirugía Dental."],
    3 => ["title" => "Diplomado en Rehabilitación Oral", "content" => "Contenido exclusivo sobre Rehabilitación Oral."]
];

$diplomado = $diplomados[$diplomado_id] ?? null;

// Si el diplomado no existe, redirigir a la página de diplomados
if (!$diplomado) {
    header("Location: diplomados.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($diplomado['title']) ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="main-header">
        <nav class="navbar">
            <div class="logo">
                <img src="assets/logo.jpg" alt="Logo">
            </div>
            <ul class="nav-links">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="courses.php">Cursos</a></li>
                <li><a href="diplomados.php">Diplomados</a></li>
                <li><a href="contacto.php">Contacto</a></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <h1><?= htmlspecialchars($diplomado['title']) ?></h1>
        <div class="content">
            <p><?= nl2br(htmlspecialchars($diplomado['content'])) ?></p>
        </div>
        <a href="diplomados.php" class="button">Volver a Diplomados</a>
    </div>

    <footer>
        <p>&copy; CEIAO | Diplomados Dentales y Consulta Especializada ®2024 Todos los Derechos Reservados</p>
    </footer>
</body>
</html>
