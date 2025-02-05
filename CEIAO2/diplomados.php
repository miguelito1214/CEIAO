<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id']; // El ID del usuario desde la sesión

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "cursos_dentistas");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los cursos completados por el usuario (progreso = 100)
$query_completed = "SELECT COUNT(*) as completed_courses 
                    FROM user_progress 
                    WHERE user_id = ? AND progress_percentage = 100";
$stmt_completed = $conn->prepare($query_completed);
$stmt_completed->bind_param("i", $user_id);
$stmt_completed->execute();
$result_completed = $stmt_completed->get_result();
$row_completed = $result_completed->fetch_assoc();
$completed_courses = $row_completed['completed_courses'];

// Consultar el total de cursos disponibles
$query_total_courses = "SELECT COUNT(*) as total_courses FROM courses";
$stmt_total_courses = $conn->prepare($query_total_courses);
$stmt_total_courses->execute();
$result_total_courses = $stmt_total_courses->get_result();
$row_total_courses = $result_total_courses->fetch_assoc();
$total_courses = $row_total_courses['total_courses'];

// Verificar si el usuario ha completado todos los cursos
if ($completed_courses == $total_courses) {
    $diplomado_message = "¡Felicidades! Has completado todos los cursos y obtienes el diplomado.";
} else {
    $diplomado_message = "Aún te faltan cursos para obtener el diplomado.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diplomado</title>
</head>
<body>
    <h1>Diplomado</h1>
    <p><?php echo $diplomado_message; ?></p>
    <a href="courses.php">Ver tus cursos</a>
</body>
</html>
