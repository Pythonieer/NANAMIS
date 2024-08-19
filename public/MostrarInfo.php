<?php
// Configuración de la base de datos
$host = 'localhost';
$db = 'nanamis';
$user = 'root';
$pass = '';

// Crear conexión a la base de datos
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta para obtener órdenes y sus detalles, ordenadas por ID de la orden
$sql = "
    SELECT o.id_orden AS orderId, o.fecha_orden AS fechaOrden,
               (SELECT COUNT(b.id) FROM banderillas b WHERE b.order_id = o.id_orden) AS banderillas_count,
               (SELECT COUNT(l.id) FROM limonadas l WHERE l.order_id = o.id_orden) AS limonadas_count,
               (SELECT GROUP_CONCAT(CONCAT('Aderezo: ', bp.aderezo, ', Empanizado: ', bp.empanizado, ', Tipo: ', bp.tipo) SEPARATOR '; ')
                FROM banderilla_personalizada bp
                WHERE bp.id IN (SELECT b.id FROM banderillas b WHERE b.order_id = o.id_orden)
               ) AS banderillas_details,
               (SELECT GROUP_CONCAT(CONCAT('Sabor: ', lp.sabor) SEPARATOR '; ')
                FROM limonada_personalizacion lp
                WHERE lp.id IN (SELECT l.id FROM limonadas l WHERE l.order_id = o.id_orden)
               ) AS limonadas_details
        FROM orden o
        ORDER BY o.id_orden ASC
";

// Ejecutar la consulta SQL y almacenar el resultado en $result
$result = $conn->query($sql);

// Crear un array para almacenar las órdenes
$orders = array();
if ($result->num_rows > 0) {
    // Si hay resultados, recorrer cada fila y agregarla al array $orders
    while ($row = $result->fetch_assoc()) {
        $orders[] = $row;
    }
}

// Enviar la respuesta en formato JSON
header('Content-Type: application/json');
// Convertir el array $orders a formato JSON y enviarlo como respuesta
echo json_encode($orders);

// Cerrar conexión
$conn->close();
?>
