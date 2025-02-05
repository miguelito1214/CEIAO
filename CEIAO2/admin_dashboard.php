<?php
session_start();

// Asegurarnos de que el usuario esté logueado (y si no, redirigirlo)
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id']; // Obtener el ID del usuario desde la sesión

// Conexión a la base de datos
$conn = new mysqli("localhost", "root", "", "cursos_dentistas");

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener las compras registradas para este usuario
$query = "SELECT c.id, c.course_id, c.fecha, c.estado, cr.title, u.name AS username
          FROM compras c
          JOIN courses cr ON c.course_id = cr.id
          JOIN users u ON c.user_id = u.id
          WHERE c.user_id = ?";

// Preparar y ejecutar la consulta
$stmt = $conn->prepare($query);
if ($stmt === false) {
    die('Error en la preparación de la consulta: ' . $conn->error);
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si hay resultados
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
    <style>
        body {
            --font-family: 'Roboto', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #003366;
            padding: 10px;
            text-align: center;
            color: white;
        }
        .container {
            max-width: 900px;
            margin: 20px auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #003366;
            color: white;
        }
        .button {
            padding: 10px 20px;
            background-color: #003366;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            display: inline-block;
        }
        .button:hover {
            background-color: #FFCC00;
        }
    </style>
</head>
<body>

<header>
    <h1>Panel de Administrador</h1>
</header>

<div class="container">
    <h2>Historial de Pagos</h2>
    
    <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Curso</th>
                    <th>Fecha de Pago</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo ucfirst($row['estado']); ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay pagos registrados.</p>
    <?php endif; ?>
    

</div>

</body>
</html>

<?php
// Cerrar la conexión y el statement al final
$stmt->close();
$conn->close();
?>
