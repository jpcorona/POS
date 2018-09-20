<?php


require("sscnn.php");


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
  <title>Factura Cloud | 2016</title>

  <!-- start: Css -->
  <link rel="stylesheet" type="text/css" href="template/asset/css/bootstrap.min.css">

  <!-- plugins -->
  <link rel="stylesheet" type="text/css" href="template/asset/css/plugins/font-awesome.min.css"/>
  <link rel="stylesheet" type="text/css" href="template/asset/css/plugins/datatables.bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="template/asset/css/plugins/animate.min.css"/>
  <link href="template/asset/css/style.css" rel="stylesheet">
  <!-- end: Css -->

  <link rel="shortcut icon" href="favicon.png" type="image/png">
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

              
                <?php 

                require("menuright.php");

                ?>



            </div>
          </div>
        </nav>
      <!-- end: Header -->

      <div class="container-fluid mimin-wrapper">
  
          <!-- start:Left Menu -->
          <?php require("menu.php");?>
          <!-- end: Left Menu -->


            <!-- start: Content -->
            <div id="content">
               <div class="panel box-shadow-none content-header">
                  <div class="panel-body">
                    <div class="col-md-12">
                        <h3 class="animated fadeInLeft">Reportes</h3>
                        <p class="animated fadeInDown">
                          <span class="fa-angle-right fa"></span> Reportes diarios o mensuales de las Ventas en POS
                        </p>
                    </div>
                  </div>
              </div>

              <div class="form-element">


                       
                      <?php if($_POST['btn']!="buscar"){?>
                  <div class="col-md-12 padding-0">
                    <div class="col-md-12">
                      <div class="panel form-element-padding">
                        <div class="panel-heading">
                         <form action="" method="post">

                         <button type="submit" name="btn" value="Cancelar" id="btnCancelar" hidden></button>
                         </form>
                         <h4>Formulario de Búsqueda por Fecha y Hora</h4>
                        </div>
                         <div class="panel-body" style="padding-bottom:30px;">

                          <form action="" method="post">
                          <div class="col-md-12">
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Fecha desde</label>
                              <div class="col-sm-5"><input type="date" name="fechaDesde" class="form-control"></div>
                              <div class="col-sm-5"><input type="time" name="horaD" class="form-control" /></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Fecha hasta</label>
                              <div class="col-sm-5"><input type="date" name="fechaHasta" class="form-control"></div>
                              <div class="col-sm-5"><input type="time" name="horaH" class="form-control" /></div>
                            </div>
                            <div class="form-group"><label class="col-sm-2 control-label text-right">Turno</label>
                              <div class="col-sm-5">
                              <select class="form-control">
                              <option>Todos</option>
                              <option>Día</option>
                              <option>Tarde</option>
                              <option>Noche</option>
                              </select>
                              </div>
                              <div class="col-sm-5"></div>
                            </div>

                        

                            <div class="col-md-12">
                            <br /><hr />
                            <button type="submit" class=" btn btn-gradient btn-info" name="btn" value="buscar"><i class="fa fa-search"></i> Buscar</button>
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
              if($_POST['btn']=="buscar"){
              ?>
              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <form action="" method="post">
                      <input type="text" name="txtBuscar" id="txtBuscar" hidden />
                      <button type="submit" name="btn" value="Buscar" id="btnBuscar" hidden></button>
                      <button type="submit" name="btn" value="Eliminar" id="btnEliminar" hidden></button>
                      <a class="pull-right btn btn-gradient btn-primary" href="reporte.pdf" download ><i class="fa fa-file-pdf-o"></i> Exportar PDF</a>
                       <button type="button" class="pull-right btn btn-gradient btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-list"></i> Cierres de caja</button>
                      <a class="pull-right btn btn-gradient btn-info" href="reporte.xls" download ><i class="fa fa-file-excel-o"></i> Exportar Excel</a>
                      <button type="submit" class="pull-right btn btn-gradient btn-success" name="btn" value="Nuevo"><i class="fa fa-plus"></i> Nueva Búsqueda</button>
                      </form>
                      <h3>Reporte</h3>

                    </div>



                        <?php

                        $nventas=0;
                        $tventas=0;
                        $tpropinas=0;

                        $tbHTML="";
                        $consultaProductos = "SELECT *, v.id as idventa FROM ventas v, ventas_detalle vd, productos p WHERE p.id=vd.producto AND v.id=vd.venta  AND v.status=0 AND v.fecha_out IS NOT NULL AND v.fecha_in between '".$_POST['fechaDesde']." ".$_POST['horaD']."' and '".date("Y-m-d",strtotime($_POST['fechaHasta'].' +1 day'))." ".$_POST['horaH']."' group by v.id";
                        if ($resultadoP = $mysqli->query($consultaProductos)) {
                        /* obtener un array asociativo PRODUCTOS */
                        while ($fila = $resultadoP->fetch_assoc()) {
                        $tbHTML.= "
                         <tr>
                          <td>".$fila['idventa']."</td>
                          <td>".date("d/m/Y H:i",strtotime($fila['fecha_in']))."</td>
                          <td>".date("d/m/Y H:i",strtotime($fila['fecha_out']))."</td>
                          <td>";
                          if($fila['mesa']==0){
                            $tbHTML.= "Para Llevar";
                          }else{
                            $tbHTML.= $fila['mesa'];
                          }
                          $tbHTML.="
                          </td>
                          <td>".$fila['tipoPago']."</td>
                          ";
                          $detalleVenta="";
                          $total=0;

                        $consultavd = "SELECT *, vd.preciou as vdprecio FROM ventas_detalle vd, productos p WHERE p.id=vd.producto AND vd.status=0 AND vd.venta=".$fila['idventa']/*." "*/;
                        if ($resultado = $mysqli->query($consultavd)) {
                        /* obtener un array asociativo PRODUCTOS */
                        while ($filavd = $resultado->fetch_assoc()) {
                          $total+=$filavd['vdprecio'];
                          $detalleVenta.=$filavd['unidades']."&nbsp;&nbsp;&nbsp;".$filavd['nombre']."&nbsp;&nbsp;&nbsp;$ ".number_format($filavd['vdprecio'],0,",",".")." <hr />";

                        }
                        
                        /* liberar el conjunto de resultados PRODUCTOS */
                        $resultado->free();

                        }   
                          $tbHTML.= "
                          <td>$ ".number_format($total-$fila['dscto'],0,",",".")."</td>
                          <td>$ ".number_format($fila['propina'],0,",",".")."</td>
                          <td>$ ".number_format($fila['dscto'],0,",",".")."</td>
                          <td>$ ".number_format($fila['pago'],0,",",".")." / $ ".number_format($fila['vuelto'],0,",",".")."</td>
                          <td>".substr($detalleVenta,0,-6)."</td>
                        </tr>
                        ";

                        $nventas++;
                        $tventas+=$total-$fila['dscto'];
                        $tpropinas+=$fila['propina'];

                        }
                        
                        /* liberar el conjunto de resultados PRODUCTOS */
                        $resultadoP->free();

                        } 


                        $TableXLS="
                        <table border='1'>
                        <tr>
                          <th>Orden</th>
                          <th>Fecha Ent.</th>
                          <th>Fecha Sal.</th>
                          <th>Mesa</th>
                          <th>Tipo Pago</th>
                          <th>Total</th>
                          <th>Propina</th>
                          <th>Dscto</th>
                          <th>Pago / Vuelto</th>
                          <th>Detalle</th>
                        </tr>
                        $tbHTML
                        </table>
                        ";
                        $TablePDF="
                        <style>
                        th{ background:#000; color: #FFF}
                        </style>
                        <table width='100%' style='border-collapse:collapse' border='1'>
                        <tr>
                          <th>Orden</th>
                          <th>Fecha Ent.</th>
                          <th>Fecha Sal.</th>
                          <th>Mesa</th>
                          <th>Tipo Pago</th>
                          <th>Total</th>
                          <th>Propina</th>
                          <th>Dscto</th>
                          <th>Pago / Vuelto</th>
                          <th>Detalle</th>
                        </tr>
                        $tbHTML
                        </table>
                        ";


                        $fp = fopen('reporte.xls', 'w');  
                        fwrite($fp,utf8_decode($TableXLS));
                        fclose($fp);
                        //readfile('reporte.xls');

                        include("MPDF5/mpdf.php");
                        $mpdf=new mPDF('utf-8',
                         'A4', // Tamaño hoja default 'A4'
                         10,     // font size - default 0
                         'verdana',    // default font family
                         10,    // margin_left
                         10,    // margin right
                         10,     // margin top
                         10,    // margin bottom
                         15,     // margin header
                         15,     // margin footer
                         'P');
                        $introPDF="
                        <h2>Reporte Ventas</h2>
                       <br />
                      <br />
                        <b>Fecha desde:</b> ".date("d/m/Y", strtotime($_POST['fechaDesde']))." - 
                        <b>Fecha hasta:</b> ".date("d/m/Y", strtotime($_POST['fechaHasta']))."<br /><br />
                         <h3>Nº Ventas: $nventas</h3>
                      <h2>Total Ventas: $".number_format($tventas,0,",",".")."</h2>
                      <h4>Total Propinas: $".number_format($tpropinas,0,",",".")."</h4>
                     
                        ";
                        $mpdf->WriteHTML($introPDF.$TablePDF);

                        $fechaBusquda=$_POST['fechaDesde']."_".$_POST['fechaHasta'];

                        $mpdf->Output('reporte.pdf');



                        ?>


                    <div class="panel-body">
                      <div class="responsive-table">

                      <h4>Fecha búsqueda: 
                      <?php print 

                      date("d/m/Y", strtotime($_POST['fechaDesde']))." - ".date("d/m/Y", strtotime($_POST['fechaHasta'])); 

                      ?>
                      </h4>
                      <h3>Nº Ventas: <?php print $nventas; ?></h3>
                      <h2>Total Ventas: $ <?php print number_format($tventas,0,",","."); ?></h2>
                      <h4>Total Propinas: $ <?php print number_format($tpropinas,0,",","."); ?></h4>
                      <br />

                      <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Orden</th>
                          <th>Fecha Ent.</th>
                          <th>Fecha Sal.</th>
                          <th>Mesa</th>
                          <th>Tipo Pago</th>
                          <th>Total</th>
                          <th>Propina</th>
                          <th>Dscto</th>
                          <th>Pago / Vuelto</th>
                          <th>Detalle</th>
                        </tr>
                      </thead>
                      <tbody>

                      <?php print $tbHTML; ?>
                        
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
        <h4 class="modal-title">Cieres de caja</h4>
      </div>
      <div class="modal-body">
      <table class="table table-striped table-bordered table-hover" id="table1">
        <thead>
          <th>Mes</th>
          <th>Fecha</th>
          <th>Usuario</th>
          <th>Monto</th>
        </thead>
        <tfoot>
          <th>Mes</th>
          <th>Fecha</th>
          <th>Usuario</th>
          <th>Monto</th>
        </tfoot>
        <tbody>
        <?php 

       //mes
        $mesArray=array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');

        $consultaProductos1 = "SELECT * FROM cierrecaja c, usrs u WHERE u.id=c.usuario";
        if ($resultadoP1 = $mysqli->query($consultaProductos1)) {
        /* obtener un array asociativo */
        while ($filaP1 = $resultadoP1->fetch_assoc()) {

 
        echo   "
               <tr>
                <td>".$mesArray[date('n',strtotime($filaP1['fecha']))]."</td>
                <td>".$filaP1['fecha']."</td>
                <td>".$filaP1['nombre']."</td>
                <td>$".number_format($filaP1['monto'],0,',','.')."</td>
              </tr>
              ";
        
        }
        
        /* liberar el conjunto de resultados */
        $resultadoP1->free();

        }    

        ?>

      <!-- start: Mobile -->
      <div id="mimin-mobile" class="reverse">
        <div class="mimin-mobile-menu-list">
            <div class="col-md-12 sub-mimin-mobile-menu-list animated fadeInLeft">
                <ul class="nav nav-list">
                    <li><a href="index.php">POS</a></li>
                    <li><a href="reportes.php">Reportes</a></li>
                    <li><a href="productos.php">Productos</a></li>
                    <li><a href="mesas.php">Mesas & Categorias</a></li>
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
    $('#datatables-example').DataTable();
  });
</script>
<!-- end: Javascript -->
</body>
</html>
<?php
/* cerrar la conexión */
$mysqli->close();
?>