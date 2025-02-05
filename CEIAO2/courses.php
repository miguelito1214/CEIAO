<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redirigir al formulario de inicio de sesión si no está autenticado
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id']; // El ID del usuario desde la sesión

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "cursos_dentistas");

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar los cursos y el progreso
$query = "SELECT courses.id, courses.title, COALESCE(user_progress.progress_percentage, 0) AS progress_percentage 
          FROM courses 
          LEFT JOIN user_progress ON courses.id = user_progress.course_id
          WHERE user_progress.user_id = ? OR user_progress.user_id IS NULL";
$stmt = $conn->prepare($query);

// Verificar si la preparación fue exitosa
if (!$stmt) {
    die("Error en la consulta: " . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si la consulta retornó resultados
if ($result->num_rows == 0) {
    $no_courses_message = "No tienes cursos disponibles.";
} else {
    $no_courses_message = null;
}

// Consultar el total de cursos y cuántos el usuario ha completado
$completed_query = "SELECT COUNT(*) as completed_courses,
                            (SELECT COUNT(*) FROM courses) AS total_courses
                    FROM user_progress
                    WHERE user_id = ? AND progress_percentage = 100";
$completed_stmt = $conn->prepare($completed_query);
$completed_stmt->bind_param("i", $user_id);
$completed_stmt->execute();
$completed_result = $completed_stmt->get_result();
$completed_row = $completed_result->fetch_assoc();

$completed_courses = $completed_row['completed_courses'];
$total_courses = $completed_row['total_courses'];

$diploma_message = null;
if ($completed_courses == $total_courses) {
    $diploma_message = "¡Felicidades! Has completado todos los cursos y ahora obtienes tu Diplomado.";
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos</title>
    <style>
        body {
            margin: 0;
            --font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #003366, #005599);
            display: flex;
            flex-direction: column;
            min-height: 100vh;
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

        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 3rem;
        }

        h1 {
            color: #003366;
            margin-bottom: 1.5rem;
            font-size: 2rem;
        }

        .course-list {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            width: 90%;
            max-width: 800px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }

        .course-list:hover {
            transform: scale(1.02);
        }

        .course-list p {
            color: #555;
            font-size: 1.1rem;
            text-align: center;
        }

        .course-list ul {
            list-style: none;
            padding: 0;
        }

        .course-list li {
            background-color: #f9f9f9;
            margin-bottom: 1rem;
            padding: 1.2rem;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: background-color 0.3s, transform 0.2s;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .course-list li:hover {
            background-color: #FFCC00;
            color: white;
            transform: scale(1.03);
        }

        .course-list li a {
            text-decoration: none;
            color: #003366;
            font-weight: bold;
            font-size: 1rem;
            transition: color 0.3s;
        }

        .course-list li:hover a {
            color: white;
        }

        .progress-container {
            width: 100%;
            background-color: #e0e0e0;
            border-radius: 10px;
            height: 10px;
            margin-top: 10px;
            overflow: hidden;
        }

        .progress-bar {
            height: 100%;
            border-radius: 10px;
            background-color: #4caf50; /* Verde */
            transition: width 0.5s ease-in-out;
        }

        .progress-bar[data-progress="0"] {
            background-color: #ff0000; /* Rojo si no hay progreso */
        }

        .progress-bar[data-progress="100"] {
            background-color: #4caf50; /* Verde cuando se completa */
        }

        .buttons {
            display: flex;
            gap: 1rem;
            margin-top: 2rem;
        }

        .button {
            background-color: #003366;
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 1rem;
            font-weight: bold;
            transition: background-color 0.3s, transform 0.2s;
            display: inline-block;
        }

        .button:hover {
            background-color: #FFCC00;
            color: white;
            transform: scale(1.05);
        }

        footer {
            background-color: #002244;
            color: white;
            padding: 1rem;
            text-align: center;
            margin-top: auto; /* Empuja el footer hacia el fondo */
        }

        .diploma-message {
            background-color: #28a745;
            padding: 1rem;
            border-radius: 8px;
            color: white;
            text-align: center;
            margin-top: 2rem;
        }

    </style>
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
        <div class="course-list">
            <h1>Lista de Cursos</h1>
            <p>Aquí están tus cursos disponibles:</p>
            <?php if ($no_courses_message): ?>
                <p><?php echo $no_courses_message; ?></p>
            <?php else: ?>
                <ul>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <li>
                            <span><?php echo $row['title']; ?></span>
                            <div class="progress-container">
                                <div class="progress-bar" style="width: <?php echo $row['progress_percentage']; ?>%" data-progress="<?php echo $row['progress_percentage']; ?>"></div>
                            </div>
                            <a href="course_detail.php?id=<?php echo $row['id']; ?>">Ver más</a>
                        </li>
                    <?php endwhile; ?>
                </ul>
            <?php endif; ?>

            <?php if ($diploma_message): ?>
                <div class="diploma-message">
                    <h2><?php echo $diploma_message; ?></h2>
                </div>
            <?php endif; ?>
        </div>

        <div class="buttons">
            <a href="index.php" class="button">Volver a la página principal</a>
            <a href="logout.php" class="button">Cerrar sesión</a>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Cursos Dentistas. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

<?php
// Cerrar la conexión a la base de datos
$conn->close();
?>
