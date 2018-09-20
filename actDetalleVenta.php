<?php
$mysqli = new mysqli("localhost", "geniapp_cloudu", "22018924", "geniapp_cloud");
$mysqli->set_charset("utf8");
/* verificar la conexión */
if ($mysqli->connect_errno) {
    printf("Conexión fallida: %s\n", $mysqli->connect_error);
    exit();
}

$detalle="";
for ($i=0; $i < count($_POST['detalle']); $i++) { 
	$detalle.=$_POST['detalle'][$i].",";


//AGREGAR SUMA PULPO
if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Pulpo"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}

if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Pollo Tempura"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}
if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Kanikama Tempura"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}

if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Piña"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}
if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Platano"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}
if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Tocino"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}
if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Beef"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }
}

  if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Vacuno"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }


}
if($_POST['cat'] == 'Promocion'){
  if($_POST['detalle'][$i] == "Champinon Tempura"){
  	$mysqli->query("UPDATE ventas_detalle SET preciou=preciou+500,precio=precio+500 WHERE id=".$_POST['id']."");

  }

}
}

//GUARDAR DETALLE NORMAL Y PROMOCIONES

if($_POST['cat']=='Promocion'){

	$mysqli->query("UPDATE promo SET detallep='".substr($detalle, 0,-1)."' WHERE id=".$_POST['idpromo']);

}else{

$mysqli->query("UPDATE ventas_detalle SET detalle='".substr($detalle, 0,-1)."' WHERE id=".$_POST['id']."");

}

?>