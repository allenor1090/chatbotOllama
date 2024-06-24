<?php
// Datos de conexión
$servername = "localhost";
$username = "root";
$password = "";
$database = "gestion_secuencias";
$port = 3306;

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database, $port);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

//echo "Conexión exitosa";

// Cerrar conexión (al finalizar tus operaciones con la base de datos)
//$conn->close();
?>