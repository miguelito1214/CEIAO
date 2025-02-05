<?php
// Verificar si el curso está especificado
if (!isset($_GET['course_id'])) {
    die("Curso no encontrado.");
}

$course_id = $_GET['course_id'];

// Iniciar sesión y verificar usuario
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
$user_id = $_SESSION['user_id'];

// Conectar a la base de datos
$conn = new mysqli("localhost", "root", "", "cursos_dentistas");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener información del curso
$sql = "SELECT * FROM courses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $course_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $course = $result->fetch_assoc();
} else {
    die("Curso no encontrado.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagar curso: <?php echo htmlspecialchars($course['title']); ?></title>
    <script src="https://www.paypal.com/sdk/js?client-id=ARMZI3-NqkzDwmDA_AL5X7P8a1gXhmIaU8MMHiohPAlnhWm60L3FCopxTbAaUdrPr4NzoaFbFqurplfd&currency=MXN"></script>
    <style>
        /* Estilos generales */
        body {
            background-color: #0A2E5D; /* Fondo azul oscuro */
            color: #fff; /* Texto blanco */
            --font-family: 'Roboto', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column;
            text-align: center;
        }

        h1 {
            color: #FFD700; /* Título en amarillo */
            margin-bottom: 20px;
            font-size: 2.5rem;
            text-transform: uppercase;
            font-weight: bold;
            letter-spacing: 2px;
        }

        p {
            font-size: 1.2rem;
            margin-bottom: 30px;
            font-weight: 300;
            letter-spacing: 1px;
        }

        .card-container {
            background-color: #1A3A72; /* Azul ligeramente más claro */
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card-container:hover {
            transform: translateY(-10px);
            box-shadow: 0px 15px 50px rgba(0, 0, 0, 0.3);
        }

        .price {
            font-size: 1.5rem;
            font-weight: 500;
            color: #FFD700;
            margin-bottom: 30px;
        }

        .paypal-button-container {
            text-align: center;
            margin-top: 30px;
        }

        .paypal-button {
            padding: 12px 30px;
            background-color: #FFD700; /* Color amarillo */
            border: none;
            border-radius: 5px;
            color: #0A2E5D; /* Color de texto azul oscuro */
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .paypal-button:hover {
            background-color: #e1b600; /* Amarillo más oscuro */
            transform: scale(1.05);
        }

        .nav-buttons {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .nav-button {
            padding: 12px 30px;
            background-color: #FFD700;
            color: #0A2E5D;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .nav-button:hover {
            background-color: #e1b600;
            transform: scale(1.05);
        }

        .footer {
            position: fixed;
            bottom: 20px;
            left: 0;
            right: 0;
            text-align: center;
            color: #fff;
            font-size: 0.9rem;
            font-weight: 300;
        }

    </style>
</head>
<body>

    <div class="card-container">
        <h1>Pagar curso: <?php echo htmlspecialchars($course['title']); ?></h1>

        <p>Bienvenido al curso de <?php echo htmlspecialchars($course['title']); ?>. A continuación puedes realizar tu pago para acceder al contenido.</p>

        <div class="price">
            <strong>Precio:</strong> $500 MXN
        </div>

        <!-- Botón de PayPal -->
        <div id="paypal-button-container"></div>

        <!-- Botones de navegación -->
        <div class="nav-buttons">
            <a href="index.php" class="nav-button">Regresar al Inicio</a>
            <a href="courses.php" class="nav-button">Ver Cursos</a>
        </div>
    </div>

    <!-- Pie de página -->
    <div class="footer">
        <p>&copy; 2025 Cursos Dentistas | Todos los derechos reservados</p>
    </div>

    <script>
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '500.00' // Precio del curso
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Pago exitoso, gracias ' + details.payer.name.given_name);
                    // Redirigir a procesar_pago.php enviando course_id y transaction_id
                    window.location.href = "procesar_pago.php?course_id=<?php echo $course_id; ?>&transaction_id=" + details.id;
                });
            },
            onError: function(err) {
                console.log(err);
                alert("Hubo un error con el pago.");
            }
        }).render('#paypal-button-container');
    </script>

</body>
</html>
