<?php
$servername = "localhost";
$username = "root"; // Cambiar si usas otro usuario
$password = ""; // Cambiar si tienes contraseña
$dbname = "cursos_dentistas";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
