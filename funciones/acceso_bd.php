<?php
function abrirConexion() {
    //funcion para abrir la conexion a la base de datos
    $pconexion = mysqli_connect($GLOBALS["servidor"], $GLOBALS["usuario"], $GLOBALS["contrasena"]) or die(mysqli_connect_error());
    return $pconexion;
}
//--------------------------------------------------------------
function seleccionarBaseDatos($pconexion) {
    //funcion para seleccionar la base de datos
    mysqli_select_db($pconexion, $GLOBALS["base_datos"]) or die(mysqli_connect_error($pconexion));
}
//--------------------------------------------------------------
function cerrarConexion($pconexion) {
    //funcion para cerrar la conexion a la base de datos
    mysqli_close($pconexion);
}
//--------------------------------------------------------------
function extraerRegistro($pconector, $cquery){

    /*Lee información solicitada (a través de una sentencia SQL) de la base de datos y la almacena
    en un arreglo que devuelve como parámetro de salida.
    Advertencia: utilizar esta función únicamente cuando se espere un sólo registro como resultado */

    $aregistro = array();
    $lresult = mysqli_query($pconector, $cquery);
    if (!$lresult){
        $cerror = "No fue posible recuperar la información de la base de datos. <br>";
        $cerror .= "SQL: $cquery <br>";
        $cerror .= "Descripción:".mysqli_connect_error($pconector);
        die($cerror);
    }
    else{
        if(mysqli_num_rows($lresult) > 0){
            $aregistro = mysqli_fetch_assoc($lresult);
        }
    }

    mysqli_free_result($lresult);
    reset($aregistro);

    return $aregistro;
}
//--------------------------------------------------------------
?>