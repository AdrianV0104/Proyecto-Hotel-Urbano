<?php

session_start();
include_once("../config.inc.php");
include_once("acceso_bd.php");

//Validar sesión
if (!isset($_SESSION['cidusuario'])) {
    header("Location: ../login.php");
    exit();
}

//Validar datos POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $checkin = $_POST['fecha_checkin'];
    $checkout = $_POST['fecha_checkout'];
    $json_carrito = $_POST['datos_reserva'];
    $id_usuario = $_SESSION['cidusuario'];

    $carrito = json_decode($json_carrito, true);

    if (empty($carrito)) {
        die("Error: El carrito está vacío.");
    }

    //Abrir conexión usando tu función
    $conn = abrirConexion();
    seleccionarBaseDatos($conn);

    try {
        //Iniciar Transacción
        $conn->begin_transaction();

        //Calcular total total de la reserva
        $total_reserva = 0;
        foreach ($carrito as $item) {
            $total_reserva += ($item['precio'] * $item['cantidad']);
        }

        //Insertar en tabla 'reservaciones'
        $sql_reserva = "INSERT INTO reservaciones (id_usuario, fecha_checkin, fecha_checkout, total, estado) 
                        VALUES (?, ?, ?, ?, 'aceptada')";
        
        $stmt = $conn->prepare($sql_reserva);
        $stmt->bind_param("issd", $id_usuario, $checkin, $checkout, $total_reserva);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al crear la reservación: " . $stmt->error);
        }
        $id_reserva = $conn->insert_id;
        $stmt->close();

        //Procesar cada item del carrito
        $sql_detalle = "INSERT INTO detalle_reservacion (id_reservacion, id_habitacion, cantidad, precio_unitario) 
                        VALUES (?, ?, ?, ?)";
        $stmt_detalle = $conn->prepare($sql_detalle);

        //Query para descontar stock
        $sql_update = "UPDATE habitaciones SET disponibles = disponibles - ? 
                       WHERE id_habitacion = ? AND disponibles >= ?";
        $stmt_update = $conn->prepare($sql_update);

        foreach ($carrito as $item) {
            $id_hab = $item['id'];
            $cantidad = $item['cantidad'];
            $precio = $item['precio'];

            // a) Insertar detalle
            $stmt_detalle->bind_param("iiid", $id_reserva, $id_hab, $cantidad, $precio);
            if (!$stmt_detalle->execute()) {
                throw new Exception("Error al guardar detalles.");
            }

            // b) Descontar disponibilidad
            $stmt_update->bind_param("iii", $cantidad, $id_hab, $cantidad);
            $stmt_update->execute();

            if ($stmt_update->affected_rows === 0) {
                throw new Exception("No hay suficiente stock para la habitación: " . $item['numero']); // O nombre/categoría
            }
        }

        $conn->commit();
        
        //Limpiamos la cookie del carrito
        setcookie('carrito_urbano', '', time() - 3600, '/');

        //Éxito
        echo "<h1>¡Reserva Exitosa!</h1>";
        echo "<p>Tu reserva ha sido procesada. Total pagado: $$total_reserva</p>";
        echo "<a href='../index.php'>Volver al inicio</a>";

    } catch (Exception $e) {
        //Si algo falla, deshacemos todo
        $conn->rollback();
        echo "<h1>Error en la reserva</h1>";
        echo "<p>" . $e->getMessage() . "</p>";
        echo "<a href='../carrito.php'>Volver al carrito</a>";
    }

    cerrarConexion($conn);

} else {
    header("Location: ../index.php");
}
?>