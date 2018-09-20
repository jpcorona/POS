<?php

session_start();

error_reporting (0);

//CONEXION MYSQL
$mysqli = new mysqli("localhost", "geniapp_cloudu", "22018924", "geniapp_cloud");
$mysqli->set_charset("utf8");
/* verificar la conexión */
if ($mysqli->connect_errno) {
    printf("Conexión fallida: %s\n", $mysqli->connect_error);
    exit();
}

//variables escapadas
$nomusr=$mysqli->real_escape_string($_POST['nomusr']);
$passusr=$mysqli->real_escape_string($_POST['passusr']);

$sqlqq1 = "SELECT * FROM usrs WHERE status=0 AND nomusr='$nomusr' AND pwdusr='$passusr'";
if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
/* obtener un array asociativo */
if ($filaLs1 = $resultadoLs1->fetch_assoc()) {

$_SESSION['idusr']=$filaLs1['id'];
$_SESSION['nombre']=$filaLs1['nombre'];
$_SESSION['nomusr']=$filaLs1['nomusr'];
$_SESSION['tipo']=$filaLs1['tipo'];

/* REGISTRAR INICIO DE SESION */
$mysqli->query("INSERT INTO login VALUES(NULL,".$filaLs1['id'].",'Inicio',NOW())");

echo 'OK';

}
}
/* liberar el conjunto de resultados */
$resultadoLs1->free();


?>