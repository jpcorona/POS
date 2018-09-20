<?php
$mysqli = new mysqli("localhost", "geniapp_cloudu", "22018924", "geniapp_cloud");
$mysqli->set_charset("utf8");
/* verificar la conexión */
if ($mysqli->connect_errno) {
    printf("Conexión fallida: %s\n", $mysqli->connect_error);
    exit();
}


$consultaProductos = "SELECT * FROM mesas WHERE estado=1";
if ($resultadoP = $mysqli->query($consultaProductos)) {
/* obtener un array asociativo PRODUCTOS */
if ($filaP = $resultadoP->fetch_assoc()) {
print "<a hidden></a>";
}else{
$mysqli->query("TRUNCATE TABLE mesas");
$e=1;
for ($i=0; $i < $_POST['totalMesas'] ; $i++) { 
	
	$mysqli->query("INSERT INTO mesas VALUES(NULL,$e,0,0)"); $e++;

}
}

/* liberar el conjunto de resultados PRODUCTOS */
$resultadoP->free();

}   

?>