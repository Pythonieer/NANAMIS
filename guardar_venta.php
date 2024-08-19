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

// Obtener los datos de la solicitud POST
$data = json_decode(file_get_contents("php://input"), true);

$id_orden = $data['id_orden'];
$cantidad_banderillas = $data['cantidad_banderillas'];
$cantidad_limonadas = $data['cantidad_limonadas'];
$total = $data['total'];
$id_user = $data['id_user'];

// Insertar los datos en la tabla ventas
$sql = "INSERT INTO ventas (id_orden, cantidad_banderillas, cantidad_limonadas, total, id_user) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiiii", $id_orden, $cantidad_banderillas, $cantidad_limonadas, $total, $id_user);

$response = array();

if ($stmt->execute()) {
    // Eliminar registros relacionados en las tablas correspondientes
    $deleteBanderillas = $conn->prepare("DELETE FROM banderillas WHERE order_id = ?");
    $deleteBanderillas->bind_param("i", $id_orden);
    $deleteBanderillas->execute();

    $deleteBanderillaPersonalizada = $conn->prepare("DELETE FROM banderilla_personalizada WHERE order_id = ?");
    $deleteBanderillaPersonalizada->bind_param("i", $id_orden);
    $deleteBanderillaPersonalizada->execute();

    $deleteLimonadas = $conn->prepare("DELETE FROM limonadas WHERE order_id = ?");
    $deleteLimonadas->bind_param("i", $id_orden);
    $deleteLimonadas->execute();

    $deleteLimonadaPersonalizacion = $conn->prepare("DELETE FROM limonada_personalizacion WHERE order_id = ?");
    $deleteLimonadaPersonalizacion->bind_param("i", $id_orden);
    $deleteLimonadaPersonalizacion->execute();

    $deleteOrden = $conn->prepare("DELETE FROM orden WHERE id_orden = ?");
    $deleteOrden->bind_param("i", $id_orden);
    $deleteOrden->execute();

    $response['success'] = true;
} else {
    $response['success'] = false;
    $response['error'] = $stmt->error;
}

$stmt->close();
$conn->close();

echo json_encode($response);
?>
