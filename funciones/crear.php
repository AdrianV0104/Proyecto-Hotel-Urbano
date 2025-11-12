<?php 
include_once("acceso_bd.php");
function agregarHabitacion(){

    $cmensaje= "";
    if(isset($_POST["btn_agregar"]) && $_POST["btn_agregar"] == "Agregar Habitación"){

        $cnumero = $_POST["txt_numero"];
        $ccategoria = $_POST["slct_categoria"];
        $nprecio = $_POST["txt_precio"];
        $ncapacidad = $_POST["txt_capacidad"];
        $ndisponible = isset($_POST["chk_disponible"]) ? 1 : 0;
        $cdescripcion = $_POST["txt_descripcion"];
        
        $cnombre_imagen = "sin imagen asociada";

        // Verificar si se subió una imagen
        if(is_uploaded_file($_FILES["fl_imagen"]["tmp_name"])) {
            $cnombre_imagen = $_FILES["fl_imagen"]["name"];
            
            // Mover la imagen a la carpeta de destino
            $carpeta_destino = "../imagenes/habitaciones/";
            
            // Crear carpeta si no existe
            if (!file_exists($carpeta_destino)) {
                mkdir($carpeta_destino, 0777, true);
            }
            
            // Generar nombre único
            $extension = pathinfo($cnombre_imagen, PATHINFO_EXTENSION);
            $cnombre_imagen = "hab_" . $cnumero . "_" . time() . "." . $extension;
            
            move_uploaded_file($_FILES["fl_imagen"]["tmp_name"], $carpeta_destino . $cnombre_imagen);
        }
        $pconexion = abrirConexion();
        seleccionarBaseDatos($pconexion);

        $cquery = "SELECT numero FROM habitaciones";
        $cquery .= " WHERE numero = '$cnumero'";

        if (!existeRegistro($pconexion, $cquery)) {
            
            $cquery = "INSERT INTO habitaciones";
            $cquery .= " (numero, imagen, precio, capacidad, disponible, descripcion, categoria)";
            $cquery .= " VALUES ('$cnumero', '$cnombre_imagen', $nprecio, $ncapacidad, $ndisponible, '$cdescripcion', '$ccategoria')";
            if (insertarDatos($pconexion, $cquery)) {
                $cmensaje = "Habitación registrada con &eacute;xito";
            }
            else {
                $cmensaje = "NO fue posible registrar la habitaci&oacute;n.";
            }
        }
        else {
            $cmensaje = "Ya existe una habitaci&oacute;n con el n&uacute;mero: $cnumero";
        }
        cerrarConexion($pconexion);

    }

    return $cmensaje;
}
?>