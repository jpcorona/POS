<?php

require('sscnn.php');


//INGRESAR CIERRE
$mysqli->query("INSERT INTO cierrecaja VALUES(NULL,NOW(),".$_SESSION['idusr'].",'".$_POST['monto']."')");

echo "Monto recaudado: $montoRecaudado";

/* REGISTRAR TERMINO DE SESION */
$mysqli->query("INSERT INTO login VALUES(NULL,".$_SESSION['idusr'].",'Termino - Cierre caja',NOW())");


session_destroy();

?>