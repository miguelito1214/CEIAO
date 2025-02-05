<?php
if (!isset($_GET['course_id']) || !isset($_GET['transaction_id'])) {
    die("Error: Datos incompletos.");
}

$course_id = $_GET['course_id'];
$transaction_id = $_GET['transaction_id'];

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: Debes iniciar sesión para completar el pago.");
}
$user_id = $_SESSION['user_id'];

$conn = new mysqli("localhost", "root", "", "cursos_dentistas");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// 🔍 Verificar si la transacción ya existe
$check_sql = "SELECT id FROM compras WHERE transaction_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $transaction_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    echo "⚠️ Este pago ya ha sido registrado.";
    echo "<br><a href='mis_cursos.php'>Ver mis cursos</a>";
    exit();
}

$check_stmt->close();

// ✅ Insertar el pago solo si no existe
$sql = "INSERT INTO compras (user_id, course_id, transaction_id, estado, fecha) VALUES (?, ?, ?, 'pagado', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iis", $user_id, $course_id, $transaction_id);

if ($stmt->execute()) {
    echo "✅ Pago exitoso. Tu curso ha sido activado.";
    echo "<br><a href='courses.php'>Ver mis cursos</a>";
} else {
    echo "❌ Error al guardar el pago: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
