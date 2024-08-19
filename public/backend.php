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
    // Si la conexión falló, mostrar un mensaje de error y terminar la ejecución
    die("Conexión fallida: " . $conn->connect_error);
}

// Obtener datos del formulario
$banderillas = $_POST['banderillas'] ?? 0; // Cantidad de banderillas solicitadas
$limonadas = $_POST['limonadas'] ?? 0; // Cantidad de limonadas solicitadas

// Insertar una nueva orden en la base de datos
$sql = "INSERT INTO orden (fecha_orden) VALUES (NOW())";
if ($conn->query($sql) === TRUE) {
    // Si la orden se inserta correctamente, obtener el ID de la nueva orden
    $orderId = $conn->insert_id;

    // Insertar banderillas
    for ($i = 1; $i <= $banderillas; $i++) {
        $sql = "INSERT INTO banderillas (order_id) VALUES ($orderId)";
        if ($conn->query($sql) === TRUE) {
            $banderillaId = $conn->insert_id;

            // Insertar personalización de banderillas
            $aderezos = $_POST["banderilla-$i-aderezo"] ?? []; // Obtener aderezos seleccionados
            $empanizados = $_POST["banderilla-$i-empanizado"] ?? []; // Obtener empanizados seleccionados
            $tipos = $_POST["banderilla-$i-tipo"] ?? []; // Obtener tipos seleccionados

            // Combinar todos los valores en una sola fila
            $aderezo = !empty($aderezos) ? implode(',', $aderezos) : '';
            $empanizado = !empty($empanizados) ? implode(',', $empanizados) : '';
            $tipo = !empty($tipos) ? implode(',', $tipos) : '';

            $sql = "INSERT INTO banderilla_personalizada (order_id, aderezo, empanizado, tipo) 
                    VALUES ($orderId, '$aderezo', '$empanizado', '$tipo')";
            $conn->query($sql);
        }
    }

    // Insertar limonadas
    for ($i = 1; $i <= $limonadas; $i++) {
        $sql = "INSERT INTO limonadas (order_id) VALUES ($orderId)";
        if ($conn->query($sql) === TRUE) {
            $limonadaId = $conn->insert_id;

            // Insertar personalización de limonadas
            $sabores = $_POST["limonada-$i-sabor"] ?? []; // Obtener sabores seleccionados
            $sabor = !empty($sabores) ? implode(',', $sabores) : '';

            $sql = "INSERT INTO limonada_personalizacion (order_id, sabor) VALUES ($orderId, '$sabor')";
            $conn->query($sql);
        }
    }

    echo "Orden registrada exitosamente!";
} else {
    // Si ocurre un error al insertar la orden, mostrar un mensaje de error
    echo "Error al registrar la orden: " . $conn->error;
}

// Cerrar conexión a la base de datos
$conn->close();
?>
