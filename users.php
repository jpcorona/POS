<?php


require('sscnn.php');


/* SOLO USUARIO ADMINISTRADOR VE ESTA PAGINA */
require('soloAdmin.php');


?>
<!DOCTYPE html>
<html lang="en">
<head>
  
  <meta charset="utf-8">
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keyword" content="">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sushi Kiya - Productos</title>

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
                 <b>Sushi Kiya</b>
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
                        <h3 class="animated fadeInLeft">Usuarios</h3>
                        <p class="animated fadeInDown">
                          <span class="fa-angle-right fa"></span> Listado de usuarios del Sistema
                        </p>
                    </div>
                  </div>
              </div>

              <?php 

              /*  BUSCAR  */
              if($_POST['btn']=="Buscar"){

               $consultaProductos = "SELECT * FROM usrs WHERE status=0 AND id=".$_POST['txtBuscar'];
              if ($resultadoP = $mysqli->query($consultaProductos)) {
              /* obtener un array asociativo PRODUCTOS */
              if ($filaP = $resultadoP->fetch_assoc()) {
              $id=$filaP['id'];
              $nombre=$filaP['nombre'];
              $nomusr=$filaP['nomusr'];
              $passusr=$filaP['pwdusr'];
              $tipousr=$filaP['tipo'];
              }
              
              /* liberar el conjunto de resultados PRODUCTOS */
              $resultadoP->free();

              }  



              }


              /*  ELIMINAR  */
              if($_POST['btn']=="Eliminar"){

              $mysqli->query("UPDATE usrs SET status=1 WHERE id=".$_POST['txtBuscar']);
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Usuario <strong>ELIMINADO</strong> correctamente.
                </div>
              </div>
              ";        
              }

              /*  ELIMINAR2  */
              if($_POST['btn']=="Eliminar2"){

              $mysqli->query("UPDATE usrs SET status=1 WHERE id=".$_POST['id']);
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Usuario <strong>ELIMINADO</strong> correctamente.
                </div>
              </div>
              ";        
              }
              


              /*  INGRESAR  */
              if($_POST['btn']=="Ingresar"){

              $nombre=$_POST['nombre'];
              $nomusr=$_POST['nomusr'];
              $passusr=$_POST['passusr'];
              $tipousr=$_POST['tipousr'];

              $mysqli->query("INSERT INTO usrs VALUES(NULL,'$nombre','$nomusr','$passusr','$tipousr',0)");
              
              $id=$mysqli->insert_id;

              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Usuario <strong>INGRESADO</strong> correctamente.
                </div>
              </div>
              ";  

              }



              /*  EDITAR  */
              if($_POST['btn']=="Editar"){

              $id=$_POST['id'];
              $nombre=$_POST['nombre'];
              $nomusr=$_POST['nomusr'];
              $passusr=$_POST['passusr'];
              $tipousr=$_POST['tipousr'];
          		
              $mysqli->query("UPDATE usrs SET nombre='$nombre',nomusr='$nomusr',pwdusr='$passusr',tipo='$tipousr' WHERE id=".$id);
              
              print "
              <div class=\"col-md-12\">
                <div class=\"alert alert-success alert-dismissible fade in\" role=\"alert\">
                  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span aria-hidden=\"true\">×</span></button>
                  <strong><span class=\"fa fa-check fa-2x\"></span> Listo!</strong>  Usuario <strong>EDITADO</strong> correctamente.
                </div>
              </div>
              ";  


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
                         <h4>Usuario</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">

                          <form action="" method="post" enctype="multipart/form-data">
                          <div class="col-md-12">

                            <div class="form-group"><label class="col-sm-2 control-label text-right">Nombre</label>
                              <div class="col-sm-10">
                                <input type="hidden" name="id" id="id" value="<?php print $id;?>">
                                <input type="text" name="nombre" value="<?php print $nombre;?>" class="form-control" required >
                              </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label text-right">Usuario</label>
                              <div class="col-sm-10">
                                <input type="text" name="nomusr" value="<?php print $nomusr;?>" class="form-control" required >
                              </div>
                            </div>

                            <div class="form-group"><label class="col-sm-2 control-label text-right">Contraseña</label>
                              <div class="col-sm-10">
                                <input type="text" name="passusr" value="<?php print $passusr;?>" class="form-control" />
                              </div>
                            </div>


                            <div class="form-group">
                              <label class="col-sm-2 control-label text-right">Tipo Usuario</label>
                              <div class="col-sm-10">
                              <select class="form-control" name="tipousr" required>
                              <option></option>
                              <option <?php if($tipousr==1){ print "selected"; } ?> value='1'>Administrador</option>
                              <option <?php if($tipousr==2){ print "selected"; } ?> value='2'>Vendedor</option>
                              </select>
                              </div>
                            </div>

                            <div class="clearfix"></div><br /><br />

                            <?php if ($id!=NULL) { ?>
                            <button type="submit" class=" btn btn-gradient btn-info" name="btn" value="Editar"><i class="fa fa-edit"></i> Guardar cambios</button>
                            <?php if($tipousr==2){  ?>
                            <button type="button" class=" btn btn-gradient btn-danger" onclick="if(confirm('Esta seguro?')){$('#btnEliminar2').click();}"><i class="fa fa-remove"></i> Eliminar</button>
                            <?php } ?>
                            <button type="submit" name="btn" value="Eliminar2" id="btnEliminar2" hidden></button>
                            <?php }else{ ?>
                            <button type="submit" class=" btn btn-gradient btn-success" name="btn" value="Ingresar"><i class="fa fa-plus"></i> Ingresar</button>
                            <?php } ?>
                            <button type="button" onclick="$('#btnCancelar').click()" class=" btn btn-gradient btn-primary" name="btn" value="Cancelar"><i class="fa fa-list"></i> Volver al listado</button>
                          </form>
                            </div>

                          </div>
                        </div>
                      </div>



                    </div>
                  </div>

              
              </div>
              <?php 

              }// id!=null

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

                      <button type="button" class="pull-right btn btn-gradient btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-list"></i> Historial inicio sesión</button>
                      
                      <button type="submit" class="pull-right btn btn-gradient btn-success" style="margin-right:3px" name="btn" value="Nuevo"><i class="fa fa-plus"></i> Agregar Nuevo</button>
                       
                      </form>
                      
                      <h3>Registros</h3>

                    </div>
                    <div class="panel-body">
                      <div class="responsive-table">
                      <table id="datatables-example" class="table table-striped table-bordered table-hover" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>ID</th>
                          <th>Nombre</th>
                          <th>Usuario</th>
                          <th>Tipo Usuario</th>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>

                       
                        <?php

                        $table1="";

                        $consultaProductos = "SELECT * FROM usrs WHERE status=0";
                        if ($resultadoP = $mysqli->query($consultaProductos)) {
                        /* obtener un array asociativo */
                        while ($filaP = $resultadoP->fetch_assoc()) {
                          
                        if ($filaP['tipo']==1) {
                          $tipousr='Administrador';
                        }
                        if ($filaP['tipo']==2) {
                          $tipousr='Vendedor';
                          $btnLsDel="<i class='btn btn-danger fa fa-remove btnEliminar' data-id=\"".$filaP['id']."\"></i>";
                        }


                        print "
                         <tr>
                          <td>".$filaP['id']."</td>
                          <td>".$filaP['nombre']."</td>
                          <td>".$filaP['nomusr']."</td>
                          <td>$tipousr</td>
                          <td>
                           <i class='btn btn-success fa fa-search btnVer' data-id=\"".$filaP['id']."\"></i>
                           <i class='btn btn-info fa fa-edit btnVer' data-id=\"".$filaP['id']."\"></i>
                           $btnLsDel
                          </td>
                        </tr>
                        ";



                        $consultaProductos1 = "SELECT * FROM login WHERE idusr=".$filaP['id'];
                        if ($resultadoP1 = $mysqli->query($consultaProductos1)) {
                        /* obtener un array asociativo */
                        while ($filaP1 = $resultadoP1->fetch_assoc()) {

                          if ($filaP1['tipo']=='Inicio') {
                            $inicioTerminio="<label class='label label-success'>Inicio</label>";
                          }else{
                            $inicioTerminio="<label class='label label-danger'>Termino</label>";
                          }

                        $table1.="
                               <tr>
                                <td>".$filaP1['fecha']."</td>
                                <td>".$filaP['nombre']."</td>
                                <td>".$filaP['nomusr']."</td>
                                <td>$tipousr</td>
                                <td>$inicioTerminio</td>
                              </tr>
                              ";
                        
                        }
                        
                        /* liberar el conjunto de resultados */
                        $resultadoP1->free();

                        }    


                        }
                        
                        /* liberar el conjunto de resultados */
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



<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="width:800px">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Historial inicio sesión</h4>
      </div>
      <div class="modal-body">
      <table class="table table-striped table-bordered table-hover" id="table1">
        <thead>
          <th>Fecha</th>
          <th>Nombre</th>
          <th>Usuario</th>
          <th>Tipo Usuario</th>
          <th>Inicio/Termino</th>
        </thead>
        <tbody>
        <?php echo $table1; ?>
        </tbody>
      </table>
      </div>
    </div>

  </div>
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


<!-- custom -->
<script src="template/asset/js/main.js"></script>
<script type="text/javascript">
  $(document).ready(function(){

    var table = $('#datatables-example').DataTable();
    var table1 = $('#table1').DataTable();

    

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