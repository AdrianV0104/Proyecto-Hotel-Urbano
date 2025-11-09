<?php
session_start();
session_destroy();
$curl = "Location: ".$GLOBALS["raiz_sitio"]."login.php";
header($curl);
exit();
?>