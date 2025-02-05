<?php
// Obtener el ID del curso desde la URL
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
} else {
    die("Curso no encontrado.");
}

// Verificar si el usuario ha iniciado sesión
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION['user_id']; // El ID del usuario desde la sesión

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "cursos_dentistas");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consultar el curso específico
$query = "SELECT title, description FROM courses WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
    // Extraer el enlace del video de la descripción
    preg_match('/https:\/\/(www\.)?(youtube\.com\/embed\/[^\s]+|vimeo\.com\/[^\s]+)/', $course['description'], $matches);
    $video_url = $matches[0]; // El enlace del video
    // Eliminar el enlace de la descripción
    $description_without_url = preg_replace('/https:\/\/(www\.)?(youtube\.com\/embed\/[^\s]+|vimeo\.com\/[^\s]+)/', '', $course['description']);
} else {
    die("Curso no encontrado.");
}

// Verificar si el usuario ha pagado por el curso
$query_pago = "SELECT estado FROM compras WHERE user_id = ? AND course_id = ? ORDER BY fecha DESC LIMIT 1";
$stmt_pago = $conn->prepare($query_pago);
$stmt_pago->bind_param("ii", $user_id, $course_id);
$stmt_pago->execute();
$result_pago = $stmt_pago->get_result();

$paid = false;
if ($result_pago->num_rows > 0) {
    $pago = $result_pago->fetch_assoc();
    if ($pago['estado'] === 'pagado') {
        $paid = true; // El usuario ha pagado
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Curso</title>
    <style>
        body {
            --font-family: 'Roboto', sans-serif;
            background: linear-gradient(to bottom, #003366, #005599);
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        header {
            background-color: #003366;
            padding: 15px 0;
            text-align: center;
            color: white;
        }
        .container {
            flex: 1;
            max-width: 900px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 2rem;
            color: white;
        }
        .description {
            font-size: 1.2rem;
            color: #555;
            line-height: 1.6;
            margin-top: 20px;
        }
        iframe {
            display: block;
            margin-top: 20px;
            width: 100%;
            height: 400px;
            border: none;
            border-radius: 8px;
        }
        .button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #003366;
            color: white;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
        }
        .button:hover {
            background-color: #FFCC00;
            color: white;
        }
        footer {
            background-color: #002244;
            color: white;
            padding: 1rem;
            text-align: center;
            margin-top: auto;
        }
    </style>
</head>
<body>

<header>
    <h1>Detalles del Curso</h1>
</header>

<div class="container">
    <h1><?php echo $course['title']; ?></h1>
    <p class="description"><?php echo $description_without_url; ?></p>
    <body oncontextmenu="return false;">


    <!-- Verificar si el usuario ha pagado antes de mostrar el video -->
    <?php if ($paid): ?>
        <?php if (!empty($video_url)): ?>
            <?php
                // Verificar si es un video de Vimeo o YouTube
                if (strpos($video_url, 'vimeo.com') !== false) {
                    // Vimeo - Incrustar con el formato de video de Vimeo
                    $embed_url = str_replace('https://vimeo.com/', 'https://player.vimeo.com/video/', $video_url);
                } else {
                    // YouTube - Usar el enlace de YouTube como está
                    $embed_url = $video_url;
                }
            ?>
            <iframe src="<?php echo $embed_url; ?>" allowfullscreen></iframe>
        <?php else: ?>
            <p>No se ha proporcionado un video para este curso.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Por favor, realice el pago para acceder al video del curso.</p>
        <a href="pago.php?course_id=<?php echo $course_id; ?>" class="button">Realizar Pago</a>
    <?php endif; ?>

    <a href="courses.php" class="button">Volver a la lista de cursos</a>
</div>

<footer>
    <p>&copy; 2025 Your Company. All rights reserved.</p>
</footer>

</body>
</html>
