<?php

require('sscnn.php');


/* SOLO USUARIO ADMINISTRADOR VE ESTA PAGINA */
require('soloAdmin.php');

class imgUpldr {
  # Variables #
  private $_exts = array("image/jpg", "image/jpeg", "image/png", "image/gif"); // Tipos de archivos soportados
  private $_width = 640; // Ancho máximo por defecto
  private $_height = 420; // Alto máximo por defecto
  private $_size = 200000; // Peso máximo. MAX_FILE_SIZE sobrescribe este valor
  private $_name = "imagen"; // Nombre por defecto 
  private $_dest = "";
  private $_img;
  private $_ext;
  private $_r = "";
  # Métodos mágicos #
  public function __set($var, $value) {
    $this->$var = $value; 
  }
  public function __get($var) {
    return $this->$var;
  }
  # Métodos propios #
  public function init($img) {
    $this->_img = $img;
    // Vemos si no pesa más que el máximo definido en $_size
    if ($this->_img['size'] <= $this->_size) {
      // Vemos si hay error
      $error = $this->_img['error'];
      switch($error) {
        case 0:
          // Verificamos que el tipo de archivo sea válido, de ser así, subimos
          if ($this->validaTipo()) {
            // Vemos si el usuario no cambió el nombre por defecto
            // Si $_name == imagen, asignamos el nombre con formato f
            if ($this->_name == "imagen") $this->asignaNombre();
            // Vemos si es mayor al tamaño por defecto
            //$tamano = list($ancho_orig, $alto_orig) = getimagesize($this->_img['tmp_name']);
            $origen = $this->_img['tmp_name'];
            // Verificamos que exista el destino, si no, lo creamos
            if ($this->_dest != "" and !is_dir($this->_dest)) {
              mkdir($this->_dest, 0775);
            }
            $destino = $this->_dest.$this->_name;
            $ancho_max = $this->_width;
            $alto_max = $this->_height;
            if ($ancho_orig > $ancho_max or $alto_orig > $alto_max) {
              $ratio_orig = $ancho_orig/$alto_orig;
              if ($ancho_max/$alto_max > $ratio_orig) {
                 $ancho_max = $alto_max*$ratio_orig;
              } else {
                 $alto_max = $ancho_max/$ratio_orig;
              }
              // Redimensionar
              $canvas = imagecreatetruecolor($ancho_max, $alto_max);
              switch($this->_img['type']) {
                case "image/jpg":
                case "image/jpeg":
                  $image = imagecreatefromjpeg($origen);
                  imagecopyresampled($canvas, $image, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
                  imagejpeg($canvas, $destino, 100);
                break; 
                case "image/gif":
                  $image = imagecreatefromgif($origen);
                  imagecopyresampled($canvas, $image, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
                  imagegif($canvas, $destino);
                break; 
                case "image/png":
                  $image = imagecreatefrompng($origen);
                  imagecopyresampled($canvas, $image, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
                  imagepng($canvas, $destino, 0);
                break; 
              }
            } else {
              move_uploaded_file($origen, $destino);
            }
          } else {
            $this->_r = "Tipo de archivo no válido."; 
          }
        break;
        case 1:
        case 2:
        $this->_r = "[".$error."] La imagen excede el tamaño máximo soportado.";
        break;
        case 3:
        $this->_r = "[".$error."] La imagen no se subió correctamente.";
        break;  
        case 4:
        $this->_r = "[".$error."] Se debe seleccionar un archivo.";
        break;  
      }
    } else {
        $this->_r = "La imagen es muy pesada.";
    }
    return $this->_r;
  }
  public function asignaNombre() { 
    // Asignamos la extensión según el tipo de archivo
    switch($this->_img['type']) {
      case "image/jpg":
      case "image/jpeg":
      $this->_ext = "jpg";
      break; 
      case "image/gif":
      $this->_ext = "gif";
      break; 
      case "image/png":
      $this->_ext = "png";
      break; 
    }
    // Asignamos el nombre a la imagen según la fecha en formato aaaammddhhiiss y la extensión
    $this->_name = date("Ymdhis").".".$this->_ext;
  }
  public function validaTipo() {
    // Verifica que la extensión sea permitida, según el arreglo $_exts
    if (in_array(strtolower($this->_img['type']), $this->_exts)) return true;
  }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Factura Cloud - Productos</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="template/asset/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="template/asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="template/asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="template/asset/css/plugins/animate.min.css"/>
  <link href="template/asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="sushikiya.png" type="image/png">
  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
</head>

<body id="mimin" class="dashboard">
      <!-- start: Header -->
        <nav class="navbar navbar-default header navbar-fixed-top">
          <div class="col-md-12 nav-wrapper">
            <div class="navbar-header" style="width:100%;">
              <div class="opener-left-menu is-open">
                <span class="top"></span>
                <span class="middle"></span>
                <span class="bottom"></span>
              </div>
                <a href="index.html" class="navbar-brand"> 
                 <b>Factura Cloud</b>
                </a>

              
                <?php require('menuright.php'); ?>


              
            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
          <?php require("menu.php"); ?>
          <!-- end: Left Menu -->


            <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft">Productos</h3>
                        <p class="animated fadeInDown">
                          <span class="fa-angle-right fa"></span> Listado de productos en POS
                        </p>
                    </div>
                  </div>
              </div>

              <?php 

              /*  BUSCAR  */
              if($_POST['btn']=="Buscar"){

               $consultaProductos = "SELECT * FROM productos WHERE id=".$_POST['txtBuscar'];
              if ($resultadoP = $mysqli->query($consultaProductos)) {
              /* obtener un array asociativo PRODUCTOS */
              if ($filaP = $resultadoP->fetch_assoc()) {
              $id=$filaP['id'];
              $nombre=$filaP['nombre'];
              $detalle=$filaP['detalle'];
              $valor=$filaP['precio'];
              $img=$filaP['img'];
              $categoria=$filaP['categoria'];
              $estado=$filaP['estado'];
              }
              
              /* liberar el conjunto de resultados PRODUCTOS */
              $resultadoP->free();

              }  



              }


              /*  ELIMINAR  */
              if($_POST['btn']=="Eliminar"){

              $mysqli->query("UPDATE productos SET status=1 WHERE id=".$_POST['txtBuscar']);
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Producto <strong>ELIMINADO</strong> correctamente.
                </div>
              </div>
              ";        
              }

              /*  ELIMINAR2  */
              if($_POST['btn']=="Eliminar2"){

              $mysqli->query("UPDATE productos SET status=1 WHERE id=".$_POST['id']);
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Producto <strong>ELIMINADO</strong> correctamente.
                </div>
              </div>
              ";        
              }
              
              /*  INGRESAR  */
              if($_POST['btn']=="Ingresar"){



          		$nombre=str_replace(' ','_',$_POST['nombre']);
              $detalle=$_POST['detalle'];
          		$valor=$_POST['valor'];
              $categoria=$_POST['categoria'];
              $estado=$_POST['estado'];
              $mysqli->query("INSERT INTO productos VALUES(NULL,'$nombre','$detalle','','$valor','$categoria','$estado',0)");
              


              /* IMG 
              include_once("class_imgUpldr.php");*/
               
              if($_FILES['imgProducto']['tmp_name']!=NULL){ 
              $subir = new imgUpldr;
              $subir->_width = 200; // El ancho máximo. Si es mayor, se ajustará
              //$subir->_height = 200; // El alto máximo. Si es mayor, se ajustará
              $subir->_size = 200000; // Asignado en bytes
              $subir->_dest = "img/"; // Deben incluir el slash al final. Si no existe el directorio, la clase lo creará.
              
              $nombreImg=date("dmYHis").$_FILES['imgProducto']['name'];
              $subir->_name = $nombreImg; // Debe incluir la extensión
              $subir->_exts = array("image/jpeg", "image/png", "image/gif"); // Arreglo, acepta valores "image/jpeg", "image/gif", "image/png"
            
              // Inicializamos
              $subir->init($_FILES['imgProducto']);
              
              if($subir->init($_FILES['imgProducto'])==""){
              
              $img1Url="img/$nombreImg";
             
              $mysqli->query("UPDATE productos SET img='$img1Url' WHERE id=".$mysqli->insert_id);
              
              }else{
                print "<script>alert('".$subir->init($_FILES['imgProducto'])."')</script>";
              }

              }else{

              $mysqli->query("UPDATE productos SET img='no-imagen.jpg' WHERE id=".$mysqli->insert_id);

              }

              $detalleq="";

              $sqlqq1 = "SELECT detalle FROM productos WHERE status=0 AND detalle!='' AND estado!='Agotado'";
              if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
              /* obtener un array asociativo */
              while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                $detalleq.=$filaLs1['detalle'].",";

              }

              /* liberar el conjunto de resultados */
              $resultadoLs1->free();

              }
              
              $mysqli->query("TRUNCATE TABLE detalle");
              //detalle de todos los productos 
              $detalleq=explode(",", substr($detalleq, 0, -1));
              
              
              $detalleq=array_unique($detalleq);
              for ($e=0; $e < count($detalleq) ; $e++) { 

              if(($key = array_search("", $detalleq)) !== false) {
                unset($detalleq[$key]); 
              }

              $mysqli->query("INSERT INTO detalle VALUES(NULL,'".$detalleq[$e]."')");

              }


              $sqlqq1 = "SELECT * FROM detalle WHERE detalle=''";
              if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
              /* obtener un array asociativo */
              while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                $mysqli->query("DELETE FROM detalle WHERE id=".$filaLs1['id']);


              }

              /* liberar el conjunto de resultados */
              $resultadoLs1->free();

              }
             

              /*
              if($_FILES['imgProducto']['tmp_name']!=NULL){
                  $ruta=$_FILES['imgProducto']['tmp_name'];               
                  $destino="img/$nombre".date("s").".jpg";
                  $mysqli->query("UPDATE productos SET img='$destino' WHERE id=".$mysqli->insert_id);
                  copy($ruta,$destino);       
                  $img=$destino;
              }else{
                $mysqli->query("UPDATE productos SET img='no-imagen.jpg' WHERE id=".$mysqli->insert_id);
              }
              */              
            
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Producto <strong>INGRESADO</strong> correctamente.
                </div>
              </div>
              ";  

              }

              /*  EDITAR  */
              if($_POST['btn']=="Editar"){
          		$nombre=str_replace(' ','_',$_POST['nombre']);
              $detalle=$_POST['detalle'];
              $valor=$_POST['valor'];
              $categoria=$_POST['categoria'];
              $estado=$_POST['estado'];
              $img=$_POST['img'];
          		

              /* IMG 
              include_once("class_imgUpldr.php"); */
               
              if($_FILES['imgProducto']['tmp_name']!=NULL or $_FILES['imgProducto']['tmp_name']!=''){ 
              $subir = new imgUpldr;
              $subir->_width = 200; // El ancho máximo. Si es mayor, se ajustará
              //$subir->_height = 200; // El alto máximo. Si es mayor, se ajustará
              $subir->_size = 200000; // Asignado en bytes
              $subir->_dest = "img/"; // Deben incluir el slash al final. Si no existe el directorio, la clase lo creará.
              
              $nombreImg=date("dmYHis").$_FILES['imgProducto']['name'];
              $subir->_name = $nombreImg; // Debe incluir la extensión
              $subir->_exts = array("image/jpeg", "image/png", "image/gif"); // Arreglo, acepta valores "image/jpeg", "image/gif", "image/png"
            
              // Inicializamos
              $subir->init($_FILES['imgProducto']);
              
              if($subir->init($_FILES['imgProducto'])==""){
              
              $img1Url="img/$nombreImg";
             
              $mysqli->query("UPDATE productos SET img='$img1Url' WHERE id=".$_POST['id']);
              
              }else{
                print "<script>alert('".$subir->init($_FILES['imgProducto'])."')</script>";
              }

              }

          		/*
          		if($_FILES['imgProducto']['tmp_name']!=NULL){
                  $ruta=$_FILES['imgProducto']['tmp_name'];               
                  $destino="img/$nombre".date("s").".jpg";
                  $mysqli->query("UPDATE productos SET img='$destino' WHERE id=".$_POST['id']);
                  copy($ruta,$destino);       
                  $img=$destino;
              }
          		*/
		        
              $mysqli->query("UPDATE productos SET nombre='$nombre', detalle='$detalle', precio='$valor', categoria='$categoria', estado='$estado' WHERE id=".$_POST['id']);
              
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Producto <strong>EDITADO</strong> correctamente.
                </div>
              </div>
              ";        




              $detalleq="";

              $sqlqq1 = "SELECT detalle FROM productos WHERE status=0 AND detalle!='' AND estado!='Agotado'";
              if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
              /* obtener un array asociativo */
              while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                $detalleq.=$filaLs1['detalle'].",";

              }

              /* liberar el conjunto de resultados */
              $resultadoLs1->free();

              }
              
              $mysqli->query("TRUNCATE TABLE detalle");
              //detalle de todos los productos 
              $detalleq=explode(",", substr($detalleq, 0, -1));
              
              
              $detalleq=array_unique($detalleq);
              for ($e=0; $e < count($detalleq) ; $e++) { 

              if(($key = array_search("", $detalleq)) !== false) {
                unset($detalleq[$key]); 
              }

              $mysqli->query("INSERT INTO detalle VALUES(NULL,'".$detalleq[$e]."')");

              }


              $sqlqq1 = "SELECT * FROM detalle WHERE detalle=''";
              if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
              /* obtener un array asociativo */
              while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                $mysqli->query("DELETE FROM detalle WHERE id=".$filaLs1['id']);


              }

              /* liberar el conjunto de resultados */
              $resultadoLs1->free();

              }


              }

              
              if($_POST['btn']=="Nuevo" or $id!=NULL){?>
              <div class="form-element">


                  <div class="col-md-12 padding-0">
                    <div class="col-md-12">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">
                         <form action="" method="post">

                         <?php if($_POST['btn']!="Nuevo" or $id!=NULL){?>
                         <button type="submit" class="pull-right btn btn-gradient btn-success" name="btn" value="Nuevo"><i class="fa fa-plus"></i> Agregar Nuevo</button>
                         <?php }?>
                         <button type="submit" name="btn" value="Cancelar" id="btnCancelar" hidden></button>
                         </form>
                         <h4>Producto</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">

                          <form action="" method="post" enctype="multipart/form-data">
                          <div class="col-md-12">
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Nombre</label>
                              <div class="col-sm-10">
                                <input type="hidden" name="id" id="idproducto" value="<?php print $id;?>">
                                <input type="text" name="nombre" value="<?php print $nombre;?>" class="form-control" required >
                              </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Detalle</label>
                              <div class="col-sm-10">
                                <input type="text" name="detalle" value="<?php print $detalle;?>" class="form-control"  >
                              </div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Valor</label>
                              <div class="col-sm-10"><input type="number" name="valor" value="<?php print $valor;?>" class="form-control" required ></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Imagen</label>
                              
                                <?php if($img!=""){?>
                                <div class="col-sm-2">
                                <img src="<?php print $img;?>" height="80px" max-width="100%" style="border:1px solid #CCC" />
                                </div>
                                <div class="col-sm-8">
                                <input type="hidden" name="img" value="<?php print $img;?>">
                                <input type="file" name="imgProducto" class="form-control">
                                </div>
                                <?php }else{?>      
                                <div class="col-sm-10">
                                <input type="hidden" name="img" value="<?php print $img;?>">
                                <input type="file" name="imgProducto" class="form-control">
                                </div>
                                <?php }?>

                            </div>
                            <br />
                            <hr style="visibility:hidden" />

                            <div class="form-group">
                              <label class="col-sm-2 control-label text-right">Categoria</label>
                              <div class="col-sm-10">
                              <select class="form-control" name="categoria" required>
                              <option></option>
                              <?php
                               $consultaProductos = "SELECT * FROM categorias WHERE status=0";
                              if ($resultadoP = $mysqli->query($consultaProductos)) {
                              /* obtener un array asociativo PRODUCTOS */
                              while ($filaP = $resultadoP->fetch_assoc()) {
                              if($categoria==$filaP['id']){ $selected=" selected"; }else{ $selected="";}
                              print "<option value='".$filaP['id']."' $selected>".$filaP['nombre']."</option>";
                              }
                              
                              /* liberar el conjunto de resultados PRODUCTOS */
                              $resultadoP->free();

                              }    
                              ?>
                              </select>
                              </div>
                            </div>

                            <div class="form-group">
                              <label class="col-sm-2 control-label text-right">Estado</label>
                              <div class="col-sm-10">
                              <select class="form-control est" name="estado" required>
                              <option></option>
                              <option <?php if($estado=="Disponible"){ print "selected"; } ?>>Disponible</option>
                              <option <?php if($estado=="Agotado"){ print "selected"; } ?>>Agotado</option>
                              </select>
                              </div>
                            </div>


                            
                            <?php 

                            //INICIO STOCK

                            if($categoria==10 or $categoria==13 or $categoria==9 or $categoria==21 or $categoria==3){ 

			             	        //CONSULTAR STOCK ACTUAL DE PRODUCTO
                            $stockActual=0;
              							$sqlqq1 = "SELECT disponible FROM stock WHERE status=0 AND producto=$id ORDER BY id DESC LIMIT 1";
              							if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
              							/* obtener un array asociativo PRODUCTOS */
              							if ($filaLs1 = $resultadoLs1->fetch_assoc()) {

              							$stockActual=$filaLs1['disponible'];

              							}
              							}
              							/* liberar el conjunto de resultados PRODUCTOS */
              							$resultadoLs1->free();

                            ?>
                            <div class="form-group">
                              <label class="col-sm-2 control-label text-right">Stock</label>
                              <div class="col-sm-10">
                              <input type="text" class="form-control" name="stock" value="<?php print $stockActual?>" disabled id="inpStock" />
                              </div>
                            </div>
                            <?php } ?>

                        

                            <div class="col-md-12">
                            <br /><hr />
                            <?php if($id!=NULL){?>             
                            <button type="submit" class=" btn btn-gradient btn-info" name="btn" value="Editar"><i class="fa fa-edit"></i> Editar</button>        


                            <?php if($categoria==10 or $categoria==13 or $categoria==9 or $categoria==21 or $categoria==3){ ?>
                            <button type="button" class=" btn btn-gradient btn-success" name="btn" value="Stock" data-toggle="modal" data-target="#myModal"><i class="fa fa-shopping-cart"></i> Stock Producto</button>

							<!-- Modal -->
							<div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog" style="width: 70% !important;">

							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Stock Producto</h4>
							      </div>
							      <div class="modal-body">

							  			  <button type="button" class="pull-right btn btn-gradient btn-success" name="btn" value="Nuevo" onclick="
							  			  if($('#divHidden').is(':hidden')){ $('#divHidden').show('swing'); }else{ $('#divHidden').slideUp(); }
							  			  "><i class="fa fa-plus"></i> Agregar Stock</button>
							  			  <div class="clearfix"></div>
							  			  <div hidden id="cargarStock"></div>
							  			  <div id="divHidden" hidden>
							  			  	
				                          <h3><i class="fa fa-plus"></i> Agregar Stock</h3>
				                          <br />
				                          
				                          <form action="" method="post">
				                          <div class="col-sm-4">
				                          <input type="number" name="ingresarStock" id="entradaStock" placeholder="Cantidad a ingresar" class="form-control" />
				                          </div>
				                          <div class="col-sm-4">
				                          <button type="button" name="btn" value="ingStock" class="btn btn-gradient btn-success" id="ingStock"><i class="fa fa-check"></i> Ingresar</button>
				                          </div>
				                          </form>

							  			  </div>

							  			  <div class="clearfix"></div><br />
					                      <table id="datatables-example1" width="100%" class="table table-striped table-bordered" cellspacing="0">
					                      <thead>
					                        <tr>
					                          <th>Fecha</th>
					                          <th>Entrada</th>
					                          <th>Salida</th>
					                          <th>Disponible</th>
                                    <th>ID Venta</th>
					                        </tr>
					                      </thead>
					                      <tbody>
					                       
					                        <?php
					                         $consultaProductos = "SELECT * FROM stock WHERE producto=$id";
					                        if ($resultadoP = $mysqli->query($consultaProductos)) {
					                        /* obtener un array asociativo PRODUCTOS */
					                        while ($filaP = $resultadoP->fetch_assoc()) {
                                  if($filaP['entrada']>0){ $entrada1=$filaP['entrada']; }else{ $entrada1=''; }
                                  if($filaP['salida']>0){ $salida1=$filaP['salida']; }else{ $salida1=''; }
					                        print "
					                         <tr>
					                          <td>".$filaP['fecha']."</td>
					                          <td>$entrada1</td>
					                          <td>$salida1</td>
                                    <td>".$filaP['disponible']."</td>
                                    <td>".$filaP['idventa']."</td>
					                        </tr>
					                        ";
					                        }
					                        
					                        /* liberar el conjunto de resultados PRODUCTOS */
					                        $resultadoP->free();

					                        }    
					                        ?>
					                        
					                      </tbody>
					                      </table>



							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-gradient btn-info" data-dismiss="modal">Cerrar</button>
							      </div>
							    </div>

							  </div>
							</div>

							<?php } ?>




                            <button type="button" class=" btn btn-gradient btn-danger" onclick="if(confirm('Esta seguro?')){$('#btnEliminar2').click();}"><i class="fa fa-remove"></i> Eliminar</button>
                            <button type="submit" name="btn" value="Eliminar2" id="btnEliminar2" hidden></button>
                            <?php }else{?>                            
                            <button type="submit" class=" btn btn-gradient btn-success" name="btn" value="Ingresar"><i class="fa fa-plus"></i> Ingresar</button>
                            <?php }?>
                            <button type="button" onclick="$('#btnCancelar').click()" class=" btn btn-gradient btn-primary" name="btn" value="Cancelar"><i class="fa fa-list"></i> Listado de productos</button>
                          </form>
                            </div>

                          </div>
                        </div>
                      </div>



                    </div>
                  </div>

              
              </div>
              <?php 
              }
              if($_POST['btn']!="Nuevo" AND $id==NULL){
              ?>
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <form action="" method="post">
                      <input type="text" name="txtBuscar" id="txtBuscar" hidden />
                      <button type="submit" name="btn" value="Buscar" id="btnBuscar" hidden></button>
                      <button type="submit" name="btn" value="Eliminar" id="btnEliminar" hidden></button>
                      <button type="submit" class="pull-right btn btn-gradient btn-success" name="btn" value="Nuevo"><i class="fa fa-plus"></i> Agregar Nuevo</button>
                      </form>
                      <h3>Registros</h3>

                    </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <style type="text/css"> tfoot{ display: table-header-group; }</style>
                      <table id="datatables-example" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <td><input type="checkbox" id="marcarTodos"/></td>
                          <th>ID</th>
                          <th>Imagen</th>
                          <th>Nombre</th>
                          <th>Detalle</th>
                          <th>Categoria</th>
                          <th>Valor</th>
                          <th>Stock</th>
                          <th>Estado</th>
                          <th width="200px">Acciones</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <td></td>
                          <th>ID</th>
                          <td></td>
                          <th>Nombre</th>
                          <th>Detalle</th>
                          <th>Categoria</th>
                          <th>Valor</th>
                          <th>Stock</th>
                          <th>Estado</th>
                          <td></td>
                        </tr>
                      </tfoot>
                      <tbody>

                       
                        <?php
                         $consultaProductos = "SELECT *,p.id as idp, c.nombre as cnombre, p.nombre as pnombre, p.detalle as pdetalle FROM productos p, categorias c WHERE c.id=p.categoria AND p.status=0";
                        if ($resultadoP = $mysqli->query($consultaProductos)) {
                        /* obtener un array asociativo PRODUCTOS */
                        while ($filaP = $resultadoP->fetch_assoc()) {
                        print "
                         <tr>
                          <td><input type=\"checkbox\" /></td>
                          <td>".$filaP['idp']."</td>
                          <td><img src=\"".$filaP['img']."\" width=\"50px\" /></td>
                          <td>".$filaP['pnombre']."</td>
                          <td>".$filaP['pdetalle']."</td>
                          <td>".$filaP['cnombre']."</td>
                          <td>$ ".number_format($filaP['precio'],0,",",".")."</td>
                          <td>";

                          //CONSULTAR STOCK ACTUAL DE PRODUCTO
                            $stockActual=0;
                            $sqlqq1 = "SELECT disponible FROM stock WHERE status=0 AND producto=".$filaP['idp']." ORDER BY id DESC LIMIT 1";
                            if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
                            /* obtener un array asociativo PRODUCTOS */
                            if ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                            echo $filaLs1['disponible'];

                            }else{
                              echo '-';
                            }
                            }
                            /* liberar el conjunto de resultados PRODUCTOS */
                            $resultadoLs1->free();

                        print "
                        </td>
                        <td>";

                          if($filaP['estado']=="Agotado"){ print "<label class='label label-danger'>Agotado</label>"; 
                          }else{ 
                            //BUSCAR STOCK
                            print "<label class='label label-success'>Disponible</label>"; 
                          }
                          print "
                          </td>
                          <td>
                          <i class='btn btn-success fa fa-search btnVer' data-id=\"".$filaP['idp']."\"></i>
                           <i class='btn btn-info fa fa-edit btnVer' data-id=\"".$filaP['idp']."\"></i>
                           <i class='btn btn-danger fa fa-remove btnEliminar' data-id=\"".$filaP['idp']."\"></i>
                          </td>
                        </tr>
                        ";
                        }
                        
                        /* liberar el conjunto de resultados PRODUCTOS */
                        $resultadoP->free();

                        }    
                        ?>
                        
                      </tbody>
                        </table>
                      </div>
                  </div>
                </div>
              </div>  
              </div>
              <?php }?>
            </div>
          <!-- end: content -->



        
      </div>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li><a href="index.php">POS</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                    <li><a href="productos.php">Productos</a></li>
                    <li><a href="mesas.php">Mesas & Categorias</a></li>
                    <li><a href="users.php">Usuarios</a></li>
                  </ul>
            </div>
        </div>       
      </div>

      <button id="mimin-mobile-menu-opener" class="animated rubberBand btn btn-circle btn-danger">
        <span class="fa fa-bars"></span>
      </button>
       <!-- end: Mobile -->

<!-- start: Javascript -->
<script src="template/asset/js/jquery.min.js"></script>
<script src="template/asset/js/jquery.ui.min.js"></script>
<script src="template/asset/js/bootstrap.min.js"></script>



<!-- plugins -->
<script src="template/asset/js/plugins/moment.min.js"></script>
<script src="template/asset/js/plugins/jquery.datatables.min.js"></script>
<script src="template/asset/js/plugins/datatables.bootstrap.min.js"></script>
<script src="template/asset/js/plugins/jquery.nicescroll.js"></script>

        <script type="text/javascript" src="sweetalert2.js"></script>
        <link rel="stylesheet" type="text/css" href="sweetalert2.css">


<!-- custom -->
<script src="template/asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    var table = $('#datatables-example').DataTable();
    var table1 = $('#datatables-example1').DataTable({"order": [[ 0, "desc" ]]});


      // Setup - add a text input to each footer cell
      $('#datatables-example tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" class="form-control" style="width:100%" placeholder="Filtrar '+title+'" />' );
      } );

      // Apply the search
      table.columns().every( function () {
          var that = this;
   
          $( 'input', this.footer() ).on( 'keyup change', function () {
              if ( that.search() !== this.value ) {
                  that
                      .search( this.value )
                      .draw();
              }
          } );

      } );



    $('#ingStock').on('click',function(){

    $('#cargarStock').load("loadStock.php",{producto:$('#idproducto').val(),entrada:$('#entradaStock').val()},function(data){

    var rs = data.split(',');

  	table1.row.add( [
        rs[0],
        rs[1],
        rs[2],
        rs[3],
        rs[4]
    ] ).draw(false);


  	$('#inpStock').val(rs[3]);

    //$('.est').

    swal('Stock actualizado!','¡Ahora tiene '+rs[3]+' unidades de este producto en Stock!','success');

    });

    });




    $('body').on('click','.btnVer',function(){
      var id = $(this).data("id");
      $('#txtBuscar').val(id);
      $('#btnBuscar').click();
    });
    $('body').on('click','.btnEliminar',function(){
      var id = $(this).data("id");
      $('#txtBuscar').val(id);
      if(confirm('Esta seguro?')){
      $('#btnEliminar').click();
      }
    });


    //Marcar Todos
    $("#marcarTodos").change(function () {
    if ($(this).is(':checked')) {
      $("input[type=checkbox]").prop('checked', true); //todos los check
    } else {
      $("input[type=checkbox]").prop('checked', false);//todos los check
    }
    });


  });
</script>
<!-- end: Javascript -->
</body>
</html>
<?php
/* cerrar la conexión */
$mysqli->close();
?>