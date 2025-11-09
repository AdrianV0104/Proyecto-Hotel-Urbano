<?php
session_start();
if (isset($_SESSION["cidusuario"])){
    header("Location:". $GLOBALS["raiz_sitio"]."index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
</head>
<body>
    <h1>Iniciar Sesión</h1>
    <form action="funciones/autenticar_login.php" method="post">
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="txt_usuario" required><br><br>
        <label for="contrasena">Contraseña:</label>
        <input type="password" id="contrasena" name="txt_contrasena" required><br><br>
        <input type="submit" name="btn_login" value="Iniciar Sesión">
    </form>
</body>
</html>