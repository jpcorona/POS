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
  <title><?php require("title.php"); echo ' | '.date("Y"); ?></title>

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

  <style type="text/css">
  tfoot{ display: table-header-group; }
  </style>

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
                 <b><?php require("title.php"); ?></b>
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
                        <h3 class="animated fadeInLeft">Reporte Ventas</h3>
                        <p class="animated fadeInDown">
                          <span class="fa-angle-right fa"></span> Listado de Ventas en POS
                        </p>
                    </div>
                  </div>
              </div>

              <div class="form-element">


              <div class="col-md-12 top-20 padding-0">
                <div class="col-md-12">
                  <div class="panel">
                    <div class="panel-heading">
                      <br >
                      <form action="" method="post">

                      <input type="text" name="txtBuscar" id="txtBuscar" hidden />
                      <button type="submit" name="btn" value="Buscar" id="btnBuscar" hidden></button>
                      <button type="submit" name="btn" value="Eliminar" id="btnEliminar" hidden></button>
                      
                      <a class="pull-right btn btn-gradient btn-info" href="reporte.xls" download ><i class="fa fa-file-excel-o"></i> Exportar Excel</a>
                      <a class="pull-right btn btn-gradient btn-primary" href="reporte.pdf" download ><i class="fa fa-file-pdf-o"></i> Exportar PDF</a>
                      <button type="button" class="pull-right btn btn-gradient btn-info" data-toggle="modal" data-target="#myModal"><i class="fa fa-list"></i> Cierres de caja</button>
                    
                      <button type="button" class="pull-right btn btn-gradient btn-success btnNuevo" name="btn" value="Nuevo"><i class="fa fa-plus"></i> Nueva Búsqueda</button>
                      Fecha desde:
                      <input type="date" id="fechadesde" />&nbsp;&nbsp;
                      Fecha hasta:
                      <input type="date" id="fechahasta" />
                     
                      </form>
                      <br />
                    </div>




                    <div class="panel-body">
                      <div class="responsive-table">


                      <div class="col-sm-6">
                      <table class="table">
                      <tr>
                        <td>Fecha búsqueda</td><td width="1%">:</td>
                        <td><?php 
                        if($fechadesde){
                        print date("d/m/Y", strtotime($fechadesde))." - ".date("d/m/Y", strtotime($fechahasta)); 
                        }else{
                          echo 'Todo';
                        }
                        ?></td>
                      </tr>
                      <tr>
                        <td>Total Ventas Hoy</td><td>:</td>
                        <td>$ <?php print number_format($tventas,0,",","."); ?></td>
                      </tr>
                      <tr>
                        <td>Total Propinas Hoy</td><td>:</td>
                        <td>$ <?php print number_format($tpropinas,0,",","."); ?></td>
                      </tr>
                        <tr>
                          <td>Ventas realizadas Hoy:</td><td>:</td>
                          <td><?php print $nventas; ?></td>
                        </tr>
                      </table>
                      </div>
                      <div class="col-sm-6">
                      <table class="table">
                      <tr>
                        <td>Total Ventas este Mes</td><td width="1%">:</td>
                        <td>$ <?php print number_format($tventas,0,",","."); ?></td>
                      </tr>
                        <tr>
                          <td>Ventas realizadas este Mes:</td><td>:</td>
                          <td><?php print $nventas; ?></td>
                        </tr>
                      <tr>
                        <td>Total Ventas esta Semana</td><td>:</td>
                        <td>$ <?php print number_format($tventas,0,",","."); ?></td>
                      </tr>
                        <tr>
                          <td>Nº Ventas esta semana:</td><td>:</td>
                          <td><?php print $nventas; ?></td>
                        </tr>
                      </table>
                      </div>
                      
                      <div class="clearfix"></div><br />
                      

                      <table id="datatables-example" class="table table-striped table-bordered" width="100%" cellspacing="0">
                      <thead>
                        <tr>
                          <th>Orden</th>
                          <th>Mes</th>
                          <th>Fecha Entrada</th>
                          <th>Fecha Salida</th>
                          <th>Mesa</th>
                          <th>Tipo Pago</th>
                          <th>Total</th>
                          <th>Propina</th>
                          <th>Dscto</th>
                          <th>Pago / Vuelto</th>
                          <th width="200px">Detalle</th>
                          <th>Usuario</th>
                          <th>Comanda Imp.</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Orden</th>
                          <th>Mes</th>
                          <th>Fecha Entrada</th>
                          <th>Fecha Salida</th>
                          <th>Mesa</th>
                          <th>Tipo Pago</th>
                          <th>Total</th>
                          <th>Propina</th>
                          <th>Dscto</th>
                          <th>Pago / Vuelto</th>
                          <th>Detalle</th>
                          <th>Usuario</th>
                          <th>Comanda Imp.</th>
                        </tr>
                      </tfoot>
                      <tbody>

                        
                      </tbody>
                        </table>


                      </div>
                  </div>
                </div>
              </div>  
              </div>




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

      $('.btnNuevo').on('click',function(){

        tablaActivos.ajax.reload();

      });

    var tablaActivos = $('#datatables-example').DataTable({
                "language": { "loadingRecords": "<h3><img src='loader.gif' width='50px' /> Cargando...</h3>" },
                "ajax":{
                    url : "dataVentas.php", // json datasource
                    type: "post",  // method  , by default get
                    data: function ( d ) {
                    d.fechadesde = $('#fechadesde').val();
                    d.fechahasta = $('#fechahasta').val();
                    },
                    error: function(){ /* error handling */ }
                    }

                });


    var tabla = $('#table1').DataTable();



     // Setup - add a text input to each footer cell
      $('#table1 tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" class="form-control" style="width:100%" placeholder="Filtrar '+title+'" />' );
      } );   
      // Apply the search
      tabla.columns().every( function () {
          var that = this;   
          $( 'input', this.footer() ).on( 'keyup change', function () {
              if ( that.search() !== this.value ) {
                  that
                      .search( this.value )
                      .draw();
              }
          } );
      } );


     // Setup - add a text input to each footer cell
      $('#datatables-example tfoot th').each( function () {
          var title = $(this).text();
          $(this).html( '<input type="text" class="form-control" style="width:100%" placeholder="Filtrar '+title+'" />' );
      } );   
      // Apply the search
      tablaActivos.columns().every( function () {
          var that = this;   
          $( 'input', this.footer() ).on( 'keyup change', function () {
              if ( that.search() !== this.value ) {
                  that
                      .search( this.value )
                      .draw();
              }
          } );
      } );

      /* VOLVER A CARGAR LA TABLA */      
      //tablaActivos.ajax.reload();



  });
</script>
<!-- end: Javascript -->
</body>
</html>
<?php
/* cerrar la conexión */
$mysqli->close();
?>