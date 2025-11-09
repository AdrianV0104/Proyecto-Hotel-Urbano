<?php
include_once("config.inc.php");
include_once("funciones/sesiones.php");
validarSesion();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio -- Hotel Urbano</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <header>
        <h1>Bienvenido al Hotel Urbano (Nombre temporal)</h1>
        <nav>
            <a href="index.php">Inicio</a>
            <?php if (!empty($_SESSION['ctipo_usuario']) && $_SESSION['ctipo_usuario'] == 'admin'): ?>
                <a href="admin/gestionar_habitaciones.php">Gestionar Habitaciones</a>
            <?php endif; ?>
            <a href="funciones/logout.php">Cerrar Sesión</a>
        </nav>
    </header>
    
    <main>
        <h2>Hola, <?php echo ($_SESSION['cnombre_usuario'] ?? 'USUARIO'); ?>!</h2>
        <p>Tipo de usuario: <?php echo ($_SESSION['ctipo_usuario'] ?? 'Visitante'); ?></p>

        <!-- Aquí irá la lista de habitaciones después -->
    </main>
</body>
</html>