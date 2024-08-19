<?php
// Configuración de la base de datos
$host = 'localhost'; // El nombre del servidor de la base de datos
$db = 'nanamis'; // El nombre de la base de datos
$user = 'root'; // El nombre de usuario de la base de datos
$pass = ''; // La contraseña del usuario de la base de datos

// Crear conexión a la base de datos usando MySQLi
$conn = new mysqli($host, $user, $pass, $db);

// Verificar si la conexión fue exitosa
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$usuario = $_POST['usuario'];
$contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT); // Encriptar la contraseña

// Insertar el nuevo usuario en la base de datos
$sql = "INSERT INTO usuarios (Nombre, Contrasena) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $usuario, $contrasena);

$response = array();

if ($stmt->execute()) {
    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
