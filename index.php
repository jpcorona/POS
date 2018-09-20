
<?php

require('sscnn.php');

?>

<!DOCTYPE html>
<html>
<head>
        <title>Factura Cloud - Ventas</title>

        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta http-equiv="content-type" content="text/html, charset=utf-8">
        <meta name="viewport" content=" width=1024, user-scalable=no">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta charset="utf-8">
        <!--
        <link rel="shortcut icon" sizes="196x196" href="touch-icon-196.png">
        <link rel="shortcut icon" sizes="128x128" href="touch-icon-128.png">
        -->
        <link rel="apple-touch-icon" href="touch-icon-iphone.png">
        <link rel="apple-touch-icon" sizes="76x76" href="touch-icon-ipad.png">
        <link rel="apple-touch-icon" sizes="120x120" href="touch-icon-iphone-retina.png">
        <link rel="apple-touch-icon" sizes="152x152" href="touch-icon-ipad-retina.png">

        <link rel="shortcut icon" type="image/png" href="sushikiya.png">

        <link rel="stylesheet" href="chosen/chosen.css">
        <style type="text/css" media="all">
        /* fix rtl for demo */
        .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        

        <style> body { background: #222; } </style> 

        
        <link href="font-awesome/css/font-awesome.css" rel="stylesheet" />
        
        <link href="style.css" rel="stylesheet">


</head>




<body class="" style="overflow-y: hidden;">
        <div class="openerp openerp_webclient_container">
            <table class="oe_webclient oe_content_full_screen">
                <tbody><tr>
                    <td class="oe_application"></td>
                </tr>
            </tbody></table>
        </div>
    
<div class="divAct" hidden></div>

<?php error_reporting (0);?>
<div class="o_control_panel"></div><div class="o_content"><div class="pos">
            <div class="pos-topheader">
                <div class="pos-branding">

                    <img class="pos-logo" src="logokiya.png" style="height:48px;margin-left: 17px" />
                    
                    <style type="text/css">
                    .btnhover a{ color: #ddd; }
                    .btnhover{ padding: 24px 18px; float: left; }
                    .btnhover,.btnhover:hover a{ color: #999; cursor: pointer; }
                    </style>

                    <div class="header-button btnhover" style="width: 120px;">
                        <a href="productos.php"> <i class="icon-dashboard"></i> Panel de Control</a>
                    </div>
                    <div class="header-button btnhover" id="cierreCaja" style="width: 80px;border-left:1px solid #555;border-right:1px solid #555">
                        <a href="#"> <i class="icon-check"></i> Cierre caja</a>
                    </div>
                    <div class="header-button btnhover" style="width: 50px;border-right:1px solid #555" onclick="$('#btnSalir').click()">
                        <a href="#"> <i class="icon-signout"></i> Salir</a>
                    </div>


                </div>
                <div class="pos-rightheader touch-scrollable">

                    <div class="order-selector" style="width: 100%;position: absolute;height: 62px;">
                    <span class="orders touch-scrollable" style="width:100%">


                        <?php
                        $consulta = "SELECT * FROM ventas WHERE status=0 AND mesa=0 AND fecha_out IS NULL ORDER BY id DESC LIMIT 1";
                        $std="";
                        if ($resultado = $mysqli->query($consulta)) {

                            /* obtener un array asociativo */
                            if ($fila = $resultado->fetch_assoc()) {
                                $std.=" style='background:red;color:white'";
                            }

                            /* liberar el conjunto de resultados */
                            $resultado->free();
                        }
                        ?>



                        <span class="order-button select-order" data-id="paraLlevar" id="mesaparaLlevarBtn" <?php print $std;?>> 
                        <span class="" style="font-size:6pt">Delivery</span>
                        </span>




                        <?php
                        $consulta = "SELECT * FROM mesas WHERE status=0";
                        $count=1;
                        if ($resultado = $mysqli->query($consulta)) {

                            /* obtener un array asociativo */
                            while ($fila = $resultado->fetch_assoc()) {
                                if($count==1){ $activo="selected"; }else{ $activo=""; } $count++;                               
                                if($fila['estado']==1){ $est="style=\"background:red;color:white\""; }else{ $est=""; }
                                print "
                                <span class=\"order-button select-order $activo\" data-id=\"".$fila['id']."\" id=\"mesa".$fila['id']."Btn\" $est>Mesa <br />
                                <span class=\"order-sequence\">".$fila['nro_mesa']."</span>
                                </span>
                                ";
                            }

                            /* liberar el conjunto de resultados */
                            $resultado->free();
                        }
                        ?>
                           


                        </span>
                    </div>

        <form action="" method="post" hidden><input type="submit" name="btn" value="Salir" id="btnSalir" /></form>

        </div>
            </div>

            <div class="pos-content">

                <div class="window">
                    <div class="subwindow">
                        <div class="subwindow-container">
                            <div class="subwindow-container-fix screens">
                                
                            <div class="product-screen screen">
                        <div class="leftpane">
                            <div class="window">
                                <div class="subwindow">
                                    <div class="subwindow-container">
                                        <div class="subwindow-container-fix">
                                            <div class="order-container">
                                                <div class="order-scroller touch-scrollable">
                        


                                                <!-- SELECCIONAR O ESCANEAR PRODUCTOS -->

                                                <br />
                                                <select hidden class="chosen-select lsEscaner" multiple="" data-placeholder="Selecciona o escanea un producto">
                                                <?php

                                                  $sqlqq1 = "SELECT *,c.nombre as nomcat,p.nombre as nombre,p.id as id FROM productos p, categorias c WHERE p.categoria=c.id AND p.status=0";
                                                  if ($resultadoLs1 = $mysqli->query($sqlqq1)) {

                                                  /* obtener un array asociativo PRODUCTOS */
                                                  while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                                                    echo "<option value='".$filaLs1['id']."'>".$filaLs1['id']." - ".str_replace('_', ' ',$filaLs1['nombre'])." - ".str_replace('_', ' ',$filaLs1['nomcat'])." - $".$filaLs1['precio']." </option>";

                                                   }

                                                   /* liberar el conjunto de resultados PRODUCTOS */
                                                   $resultadoLs1->free();
                                                   }//fin 

                                                ?>
                                                </select>
                                                <br />


                                <!-- COMANDA MESA PARA LLEVAR -->

                                <div class="order" id="mesaparaLlevarDiv" hidden>

                                <?php
                                
                                $consultap = "SELECT * FROM ventas WHERE status=0 AND mesa=0 AND fecha_out IS NULL ORDER BY id DESC LIMIT 1";
                                    
                                    if ($resultadop = $mysqli->query($consultap)) {

                                        /* obtener un array asociativo */
                                        if ($filap = $resultadop->fetch_assoc()) {



                                            print "
                                            <ul class=\"orderlines\" id=\"orderlinesparaLlevar\">                        
                                            
                                            <!-- DETALLE LISTA COMANDA-->
                                            <li class=\"orderline\" style=\"cursor:default;\">
                                            <ul class=\"info-list\">
                                            <li class=\"info\" style=\"font-size:10pt;\">
                                                <em>Fecha:</em> ".date("d/m/Y H:i", strtotime($filap['fecha_in']))."
                                                &nbsp;&nbsp;
                                                <em>Para Llevar</em>
                                                &nbsp;&nbsp;
                                                <em>Orden #</em>".$filap['id']."<input type='hidden' value='".$filap['id']."' id='ventaMesaparaLlevar' /><input type='hidden' value='".date("d/m/Y H:i", strtotime($filap['fecha_in']))."' id='fechaVentaMesaparaLlevar' />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </li>
                                            <li style=\"font-size:10pt;\">                                               
                                            <div hidden class='datoCliente'></div>
                                            
                                            <input style=\"border: 1px solid #a8d4f3;padding: 5px;border-radius: 3px;\" type='text' data-id='".$filap['id']."' value='".$filap['nomCliente']."'
                                            onblur=\"$('.datoCliente').load('nomCliente.php',{id:$(this).data('id'),nomCliente:$(this).val()},function(){})\" 
                                            placeholder='Nombre Cliente' /> 
                                             
                                            <input style=\"border: 1px solid #a8d4f3;padding: 5px;border-radius: 3px;\" type='text' data-id='".$filap['id']."' value='".$filap['telCliente']."'
                                            onblur=\"$('.datoCliente').load('telCliente.php',{id:$(this).data('id'),telCliente:$(this).val()},function(){})\" 
                                            placeholder='Telefono Cliente' /> 
                                            
                                            </li>
                                            </ul>
                                            </li>

                                            ";
                                            $consultaP = "SELECT *, v.id as idventaDetalle, v.detalle as detalleVenta,p.id as idp FROM ventas_detalle v, productos p WHERE p.id=v.producto AND v.status=0 AND v.venta=".$filap['id']." ORDER BY v.id";
                                            $count2=0; $promo2=0;
                                            if ($resultadoP = $mysqli->query($consultaP)) {
                                                              
                                                /* obtener un array asociativo */
                                                while ($filaP = $resultadoP->fetch_assoc()) {

                                                    print "
                                                    <li class=\"orderline\">
                                                    <span class=\"product-name\">".$filaP['nombre']." </span>
                                                    <span class=\"price\">$ ".number_format($filaP['preciou']*$filaP['unidades'],0,",",".")."
                                                    <i class=\"btn\" data-id=\"".$filaP['idventaDetalle']."\" data-prod=\"".$filaP['idp']."\">x</i>
                                                    </span>
                                                    <ul class=\"info-list\">

                                                    <li class=\"info\">Valor $".number_format($filaP['preciou'],0,",",".")." * <em>".$filaP['unidades']."</em> Unidad(es)
                                                    <i class=\"btnDetalle\" onclick=\"
                                                    $('.chosen-select').slideUp();
                                                    if($(this).parent('li').find('div').is(':hidden')){
                                                        $(this).parent('li').find('div').show('swing');
                                                    }else{
                                                        $(this).parent('li').find('div').slideUp();
                                                    }
                                                    \">Detalle</i>

                                                    <div class='divDetalle' hidden style=\"padding-top:10px\">
                                                    

                                                    <div>
                                                      <select data-placeholder=\"Selecciona productos\" onchange=\"($(this).val()+' id:'+$(this).data('id'))\" data-id=\"".$filaP['idventaDetalle']."\" class=\"chosen-select\" multiple tabindex=\"6\">
                                                        <option value=\"\"></option>
                                                        <optgroup label=\"Detalle\">
                                                          ";

                                                          //detalle de producto en ventas_detalle q se esta listando
                                                          $detalle1=explode(",", $filaP['detalleVenta']);

                                                          for ($e=0; $e < count($detalle1) ; $e++) { 

                                                              print "<option selected>".$detalle1[$e]."</option>"; 

                                                          }
                                                          

                                                          $sqlqq1 = "SELECT detalle FROM detalle";
                                                          if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
                                                          /* obtener un array asociativo */
                                                          while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                                                             print "<option>".$filaLs1['detalle']."</option>";

                                                          }

                                                          /* liberar el conjunto de resultados */
                                                          $resultadoLs1->free();

                                                          }
                                                          

                                                        print "</optgroup>
                                                      </select>
                                                    </div>

                                                    </div>

                                                    </li>
                                                    </ul>
                                                    </li>
                                                    ";
                                                    $count2+=$filaP['preciou']*$filaP['unidades'];

                                                     /* CONTAR PROMOCIONES 

                                                        if($filaP['categoria']==24){
                                                            $promo2+=$filaP['unidades'];
                                                        }*/

                                                }

                                                /* liberar el conjunto de resultados */
                                                $resultadoP->free();
                                            }
                                            
                                            $consultaP = "SELECT * FROM ventas_detalle v, productos p WHERE p.id=v.producto AND v.status=0 AND v.venta=".$filap['id']." ORDER BY v.id";
                                            
                                            if ($resultadoP = $mysqli->query($consultaP)) {
                                                              
                                                /* obtener un array asociativo */
                                                if ($filaP = $resultadoP->fetch_assoc()) {

                                                }else{
                                                print "<li class=\"orderline\" style=\"cursor:default;\">
                                                <ul class=\"info-list\">
                                                <li class=\"info\" style=\"font-size:10pt;color:#CCC\">
                                                    <i>Haz click en los productos para agregar</i>
                                                </li>

                                                </li>";
                                                }

                                                /* liberar el conjunto de resultados */
                                                $resultadoP->free();
                                            }



                                                /* DSCTO PROMOCIONES 
                                                
                                                if($promo>1){
                                                    $dscto=$promo*500;
                                                    $mysqli->query("UPDATE ventas SET dscto='$dscto' WHERE id=$idventa");
                                                    $count-=$dscto;
                                                }
                                                */





                                            /* APLICAR DSCTO POR TOTAL DE LA COMPRA */
                                            $dscto1=0;
                                            if ($filap['dscto']!=0) {                                                
                                                if(strlen($filap['dscto'])==1){ $dscto1='0.0'.$filap['dscto']; }
                                                if(strlen($filap['dscto'])==2){ $dscto1='0.'.$filap['dscto']; }
                                                $dscto1=$count2*$dscto1;
                                                $count2-=$dscto1;
                                            }


                                         print "
                                            </ul>
                                            <!-- TOTAL MESA paraLlevar -->
                                            <div class=\"summary clearfix\">
                                                <div class=\"line lineDivparaLlevar\">
                                                    <div class=\"entry total\">
                                                        <span class=\"label\">Total: $ <span id=\"totalMesaparaLlevar\" >".number_format($count2,0,",",".")."</span></span>
                                                        <div class=\"subentry\"><input type=\"checkbox\" id=\"propinaMesaparaLlevar\" value=\"".$count2*0.1."\" onclick=\"$('.inputCash').click()\"> +10% Propina: $ ".number_format($count2*0.1+$count2,0,",",".")."</div>
                                                        <div class=\"subentry\"> Dscto. Promoción: % <input type='text' id=\"dsctoMesaparaLlevar\" class=\"dsctoinp1\" style='width:20px ;border: 1px solid #a8d4f3;padding: 5px;border-radius: 3px;' value='".($filap['dscto'])."' /> ($".number_format($dscto1,0,',','.').")</div>
            
                                                        <div class=\"subentry\"><b>Vuelto: $ <span id=\"vueltoMesaparaLlevar\">0</span></b></div>
                                                    </div>
                                                </div>
                                            </div>";

                                        }else{

                                            print "
                                            <br /><br />
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            &nbsp;&nbsp;&nbsp;
                                            <span class='btn1'>Nueva Venta</span>";

                                        }

                                        /* liberar el conjunto de resultados */
                                        $resultadop->free();
                                    }

                               


                                ?>


                                </div>
                                <!-- ./MESA PARA LLEVAR -->



                        <?php

                        /* MOSTRAR AL RECARGAR LA PAGINA */


                        $consulta = "SELECT * FROM mesas WHERE status=0";
                        $count=1;
                        if ($resultado = $mysqli->query($consulta)) {

                            /* obtener un array asociativo */
                            while ($fila = $resultado->fetch_assoc()) {
                                if($count>1){ $est="hidden"; }else{ $est=""; }
                                $count++;
                                print "                             
                                <!-- COMANDA MESA ".$fila['id']." -->
                                <div class=\"order\" id=\"mesa".$fila['id']."Div\" $est>";
                                if($fila['estado']==1){


                  

                                    $consultap = "SELECT * FROM ventas WHERE status=0 AND mesa=".$fila['id']." ORDER BY id DESC LIMIT 1";
                                    
                                    if ($resultadop = $mysqli->query($consultap)) {

                                        /* obtener un array asociativo */
                                        if ($filap = $resultadop->fetch_assoc()) {
                                            print "
                                            <ul class=\"orderlines\" id=\"orderlines".$fila['id']."\">                        
                                            
                                            <!-- DETALLE LISTA COMANDA-->
                                            <li class=\"orderline\" style=\"cursor:default;\">
                                            <ul class=\"info-list\">
                                            <li class=\"info\" style=\"font-size:10pt;\">
                                                <em>Fecha:</em> ".date("d/m/Y H:i", strtotime($filap['fecha_in']))."
                                                &nbsp;&nbsp;&nbsp;&nbsp;
                                                <em>Mesa:</em> ".$fila['id']."
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                <em>Orden #</em> ".$filap['id']."<input type='hidden' value='".$filap['id']."' id='ventaMesa".$fila['id']."' /><input type='hidden' value='".date("d/m/Y H:i", strtotime($filap['fecha_in']))."' id='fechaVentaMesa".$fila['id']."' />
                                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </li>
                                            <li>
                                            
                                            <div hidden class='datoCliente'></div>
                                            
                                            <input style=\"border: 1px solid #a8d4f3;padding: 5px;border-radius: 3px;\" type='text' data-id='".$filap['id']."' value='".$filap['nomCliente']."'
                                            onblur=\"$('.datoCliente').load('nomCliente.php',{id:$(this).data('id'),nomCliente:$(this).val()},function(){})\" 
                                            placeholder='Nombre Cliente' /> 

                                            <input style=\"border: 1px solid #a8d4f3;padding: 5px;border-radius: 3px;\" type='text' data-id='".$filap['id']."' value='".$filap['telCliente']."'
                                            onblur=\"$('.datoCliente').load('telCliente.php',{id:$(this).data('id'),telCliente:$(this).val()},function(){})\" 
                                            placeholder='Telefono Cliente' /> 

                                            
                                            </li>
                                            </ul>
                                            </li>

                                            ";
                                            $consultaP = "SELECT *, v.id as idventaDetalle, v.detalle as detalleVenta,p.id as idprodd, p.categoria as cat FROM ventas_detalle v, productos p WHERE p.id=v.producto AND v.status=0 AND v.venta=".$filap['id']." ORDER BY v.id";
                                            $count2="0";
                                            if ($resultadoP = $mysqli->query($consultaP)) {
                                                              
                                                /* obtener un array asociativo */
                                                while ($filaP = $resultadoP->fetch_assoc()) {

                                                    print "
                                                    <li class=\"orderline\">
                                                    <span class=\"product-name\">".$filaP['nombre']." </span>                                                    
                                                    <span class=\"price\">$ ".number_format($filaP['preciou']*$filaP['unidades'],0,",",".")."
                                                    <i class=\"btn\" data-id=\"".$filaP['idventaDetalle']."\" data-prod=\"".$filaP['idprodd']."\">x</i>
                                                    </span>
                                                    <ul class=\"info-list\">
                                                    <li class=\"info\">Valor $".number_format($filaP['preciou'],0,",",".")." * <em>".$filaP['unidades']."</em> Unidad(es)

                                                    ";


                                                    /* INICIO ENVOLTURAS Y DETALLE INGREDIENTES */

                                                    if($filaP['cat']==1){
                                                    print "<br />Env. <select class='envSelect' data-id=\"".$filaP['idventaDetalle']."\" data-prod=\"".$filaP['idprodd']."\"><option></option>";

                                                    print "<option "; if($filaP['env']=="Sesamo"){ print "selected"; }
                                                    print ">Sesamo</option>";
                                                    print "<option "; if($filaP['env']=="Mix Semillas"){ print "selected"; }
                                                    print ">Mix Semillas</option>";
                                                    print "<option "; if($filaP['env']=="Ciboulette"){ print "selected"; }
                                                    print ">Ciboulette</option>";
                                                    print "<option "; if($filaP['env']=="Massago"){ print "selected"; }
                                                    print ">Massago</option>";
                                                                                     


                                                    print "</select>&nbsp;&nbsp;";
                                                    }
                                                    if($filaP['cat']==2){
                                                    print "<br />Env. <select class='envSelect' data-id=\"".$filaP['idventaDetalle']."\" data-prod=\"".$filaP['idprodd']."\"><option></option>";

                                                    print "<option "; if($filaP['env']=="Panko"){ print "selected"; }
                                                    print ">Panko</option>";
                                                    print "<option "; if($filaP['env']=="Salmon"){ print "selected"; }
                                                    print ">Salmon</option>";
                                                    print "<option "; if($filaP['env']=="Palta"){ print "selected"; }
                                                    print ">Palta</option>";
                                                    print "<option "; if($filaP['env']=="Queso Crema"){ print "selected"; }
                                                    print ">Queso Crema</option>";


                                                    print "</select>&nbsp;&nbsp;";
                                                    }
                                                    if($filaP['cat']==5){
                                                    print "<br />Env. <select class='envSelect' data-id=\"".$filaP['idventaDetalle']."\" data-prod=\"".$filaP['idprodd']."\"><option></option>";

                                                    print "<option "; if($filaP['env']=="Nori"){ print "selected"; }
                                                    print ">Nori</option>";
                                                    print "<option "; if($filaP['env']=="Sesamo"){ print "selected"; }
                                                    print ">Sesamo</option>";
                                                    print "<option "; if($filaP['env']=="Tempura"){ print "selected"; }
                                                    print ">Tempura</option>";


                                                    print "</select>&nbsp;&nbsp;";
                                                    }
                                                    
                                                    //CATEGORIA PROMOCIONES
                                                    if($filaP['cat']==11){
                                                      
                                                      $sqlqq2 = "SELECT id,detallep,envp FROM promo WHERE idventadetalle=".$filaP['idventaDetalle'];
                                                      if ($resultadoLs2 = $mysqli->query($sqlqq2)) {
                                                      /* obtener un array asociativo */
                                                      while ($filaLs2 = $resultadoLs2->fetch_assoc()) {

                                                    

                                                        
                                                    //ENVOLTURA PROMOCIONES
                                                    print"<div>";
                                                    print "Env. <select class='envSelectP' data-id=\"".$filaP['idventaDetalle']."\" data-idpromo=\"".$filaLs2['id']."\" data-prod=\"".$filaP['idprodd']."\"><option></option>";

                                                    print "<option "; if($filaLs2['envp']=="Panko"){ print "selected"; }
                                                    print ">Panko</option>";
                                                    print "<option "; if($filaLs2['envp']=="Palta"){ print "selected"; }
                                                    print ">Palta</option>";
                                                    print "<option "; if($filaLs2['envp']=="Salmon"){ print "selected"; }
                                                    print ">Salmon</option>";
                                                    print "<option "; if($filaLs2['envp']=="Queso Crema"){ print "selected"; }
                                                    print ">Queso Crema</option>";
                                                    print "<option "; if($filaLs2['envp']=="Massago"){ print "selected"; }
                                                    print ">Massago</option>";
                                                    print "<option "; if($filaLs2['envp']=="Ciboulette"){ print "selected"; }
                                                    print ">Ciboulette</option>";
                                                    print "<option "; if($filaLs2['envp']=="Sesamo"){ print "selected"; }
                                                    print ">Sesamo</option>";
                                                    print "<option "; if($filaLs2['envp']=="Nori"){ print "selected"; }
                                                    print ">Nori</option>";

                                                    print "<option "; if($filaLs2['envp']=="Sesamo Mix"){ print "selected"; }
                                                    print ">Sesamo Mix</option>";

                                                    print "</select>&nbsp;&nbsp;";





                                                    // INGREDIENTES PROMOCIONES

                                                    print"<i class=\"btnDetalle\" onclick=\" 
                                                    
                                                    $('.divDetalle').slideUp();
                                                    if($(this).parent('div').find('.divDetalle').is(':hidden')){
                                                        $(this).parent('div').find('.divDetalle').show('swing');
                                                    }else{
                                                        $(this).parent('div').find('.divDetalle').slideUp();
                                                    }
                                                    \">Detalle</i>

                                                    
                                                    <div class='divDetalle' hidden style=\"padding-top:10px; padding-bottom:10px\">
                                                    

                                                    <div>
                                                      <select data-placeholder=\"Selecciona detalle\" onchange=\"$('.divAct').load('actDetalleVenta.php',{idpromo:$(this).data('idpromo'),id:$(this).data('id'),detalle:$(this).val(),rolls:$(this).data('rolls'),cat:'Promocion'},function(){})
                                                        \"  data-id=\"".$filaP['idventaDetalle']."\" data-idpromo=\"".$filaLs2['id']."\" data-rolls=\"$numPromo\" class=\"chosen-select\" multiple tabindex=\"6\">
                                                        <option value=\"\"></option>
                                                        <optgroup label=\"Detalle\"> ";

                                                      //detalle de producto en ventas_detalle q se esta listando
                                                      $detalle1=explode(",", $filaLs2['detallep']);

                                                      for ($e=0; $e < count($detalle1) ; $e++) { 

                                                          print "<option selected>".$detalle1[$e]."</option>"; 

                                                      }
                                                      

                                                      $sqlqq1 = "SELECT detalle FROM detalle";
                                                      if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
                                                      /* obtener un array asociativo */
                                                      while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                                                         print "<option>".$filaLs1['detalle']."</option>";

                                                      }

                                                      /* liberar el conjunto de resultados */
                                                      $resultadoLs1->free();

                                                      }
                                                          
                                                    /* AGREGAR INGREDIENTES MANUALMENTE */
                                                    $option="
                                                    <option>Atun</option>
                                                    <option>Reineta</option>
                                                    <option>Pulpo</option>
                                                    <option>Palmito</option>
                                                    <option>Kanikama</option>
                                                    <option>Pepino</option>
                                                    <option>Camaron</option>
                                                    <option>Ciboulette</option>
                                                    <option>Choclo</option>
                                                    ";

                                                    print "

                                                    $option

                                                    </optgroup>
                                                    </select>
                                                    </div>

                                                    </div>
                                                    </div>
                                                    ";

                                                      }

                                                      /* liberar el conjunto de resultados */
                                                      $resultadoLs2->free();

                                                      }

                                                    }



                                                    if($filaP['cat']!=10 AND $filaP['cat']!=6 AND $filaP['cat']!=8 AND $filaP['cat']!=9 AND $filaP['cat']!=11){

                                                    print "<i class=\"btnDetalle\" onclick=\"
                                                    
                                                    $('.divDetalle').slideUp();
                                                    if($(this).parent('li').find('div').is(':hidden')){
                                                        $(this).parent('li').find('div').show('swing');
                                                    }else{
                                                        $(this).parent('li').find('div').slideUp();
                                                    }
                                                    \">Detalle</i>

                                                    <div class='divDetalle' hidden style=\"padding-top:10px\">
                                                    

                                                    <div>
                                                      <select data-placeholder=\"Selecciona productos\" onchange=\"$('.divAct').load('actDetalleVenta.php',{id:$(this).data('id'),detalle:$(this).val()},function(){})
                                                        \" data-id=\"".$filaP['idventaDetalle']."\" class=\"chosen-select\" multiple tabindex=\"6\">
                                                        <option value=\"\"></option>
                                                        <optgroup label=\"Detalle\">
                                                          ";


                                                          //detalle de producto en ventas_detalle q se esta listando
                                                          $detalle1=explode(",", $filaP['detalleVenta']);

                                                          for ($e=0; $e < count($detalle1) ; $e++) { 

                                                              print "<option selected>".$detalle1[$e]."</option>"; 

                                                          }
                                                          

                                                          $sqlqq1 = "SELECT detalle FROM detalle";
                                                          if ($resultadoLs1 = $mysqli->query($sqlqq1)) {
                                                          /* obtener un array asociativo */
                                                          while ($filaLs1 = $resultadoLs1->fetch_assoc()) {

                                                             print "<option>".$filaLs1['detalle']."</option>";

                                                          }

                                                          /* liberar el conjunto de resultados */
                                                          $resultadoLs1->free();

                                                          }
                                                        
                                                        /* AGREGAR INGREDIENTES MANUALMENTE */
                                                        $option="
                                                        <option>Atun</option>
                                                        <option>Reineta</option>
                                                        <option>Pulpo</option>
                                                        <option>Palmito</option>
                                                        <option>Kanikama</option>
                                                        <option>Pepino</option>
                                                        <option>Camaron</option>
                                                        <option>Ciboulette</option>
                                                        <option>Choclo</option>
                                                        ";


                                                        print "

                                                        $option

                                                        </optgroup>
                                                        </select>
                                                        </div>

                                                    </div>";
                                                    }

                                                    /* FIN ENVOLTURAS Y DETALLE INGREDIENTES */

                                                    print "
                                                    </li>
                                                    </ul>
                                                    </li>
                                                    ";

                                                    //CALCULAR TOTAL VENTA MESA
                                                    $count2+=$filaP['preciou']*$filaP['unidades'];

                                                        /* CONTAR PROMOCIONES 

                                                        if($filaP['categoria']==24){
                                                            $promo2+=$filaP['unidades'];
                                                        }*/




                                                }

                                                /* liberar el conjunto de resultados */
                                                $resultadoP->free();
                                            }
                                            







                                            $consultaP = "SELECT * FROM ventas_detalle v, productos p WHERE p.id=v.producto AND v.status=0 AND v.venta=".$filap['id']." ORDER BY v.id";
                                            
                                            if ($resultadoP = $mysqli->query($consultaP)) {
                                                              
                                                /* obtener un array asociativo */
                                                if ($filaP = $resultadoP->fetch_assoc()) {

                                                }else{
                                                print "<li class=\"orderline\" style=\"cursor:default;\">
                                                <ul class=\"info-list\">
                                                <li class=\"info\" style=\"font-size:10pt;color:#CCC\">
                                                    <i>Haz click en los productos para agregar</i>
                                                </li>
                                                </ul>
                                                </li>";
                                                }

                                                /* liberar el conjunto de resultados */
                                                $resultadoP->free();
                                            }

   

                                        }

                                        /* liberar el conjunto de resultados */
                                        $resultadop->free();
                                    }



                                            /* APLICAR DSCTO POR TOTAL DE LA COMPRA */
                                            $dscto1=0;
                                            if ($filap['dscto']!=0) {                                                                                                
                                                if(strlen($filap['dscto'])==1){ $dscto1='0.0'.$filap['dscto']; }
                                                if(strlen($filap['dscto'])==2){ $dscto1='0.'.$filap['dscto']; }
                                                $dscto1=$count2*$dscto1;
                                                $count2-=$dscto1;
                                            }


                                print "
                                </ul>
                                <!-- TOTAL MESA ".$fila['id']." -->
                                <div class=\"summary clearfix\">
                                    <div class=\"line lineDiv".$fila['id']."\">
                                        <div class=\"entry total\">
                                            <span class=\"label\">Total: $ <span id=\"totalMesa".$fila['id']."\" >".number_format($count2,0,",",".")."</span></span>
                                            <div class=\"subentry\" style=\"padding:5px 0 5px 0\"><label style=\"padding: 5px;border: 1px solid #ddd;border-radius: 6px;background: #f3f3f3;cursor: pointer;\" onclick=\"$('.inputCash').click()\"><input type=\"checkbox\" id=\"propinaMesa".$fila['id']."\" value=\"".$count2*0.1."\"> +10% Propina: $ ".number_format($count2*0.1+$count2,0,",",".")."</label></div>
                                            <div class=\"subentry\"> Dscto. Promoción: % <input type='text' class=\"dsctoinp\" id=\"dsctoMesa".$fila['id']."\" style='width:20px ;border: 1px solid #a8d4f3;padding: 5px;border-radius: 3px;' value='".($filap['dscto'])."' /> ($".number_format($dscto1,0,',','.').")</div>
                                            <div class=\"subentry\"><b>Vuelto: $ <span id=\"vueltoMesa".$fila['id']."\">0</span></b></div>
                                        </div>
                                    </div>
                                </div>";


                                }else{
                                print "<br /><br />
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;
                                <span class='btn1'>Nueva Venta</span>";
                                }
                                print "
                                </div>
                                <!-- ./MESA ".$fila['id']." -->\n
                                ";
                            }

                            /* liberar el conjunto de resultados */
                            $resultado->free();
                            }
                            ?>



                                </div>
                            </div>
                            </div>
                        </div>
                    </div>





                    <div class="subwindow collapsed">
                        <div class="subwindow-container">


                            <div class="subwindow-container-fix pads">

                                <div id="btnsCall">
                                <div class="actionpad">
                                    <button class="button set-customer btnPay" style="padding:0;font-family:verdana; font-size:20pt; height:107px;background:linear-gradient(#8BC34A,#4CAF50);color:#FFF">
                                        <i class="icon-dollar"></i> Pagar
                                    </button>
                                </div>
                                <div class="actionpad">
                                    <button class="button set-customer impComanda"  style="float:left;width:50%;padding:0;font-size:20pt;background:linear-gradient(#03A9F4,#3F51B5);color:#EEE;">
                                        <i class="fa fa-print" style="font-size:10pt"></i> <span  style="font-family:verdana;font-size:9pt"> Comanda</span>
                                        <div class="divImpComanda" hidden></div>
                                    </button>
                                    <button class="button set-customer impCuenta"  style="float:left;width:50%;padding:0;font-size:20pt;background:linear-gradient(#f7f114,#9e9a21);color:#EEE;">
                                        <i class="fa fa-print"></i> <span  style="font-family:verdana;font-size:9pt"> Cuenta</span>
                                        
                                    </button>
                                    <button class="button set-customer btnCancelarVenta" style="padding:0;font-family:verdana;background:linear-gradient(#fc3c3c,#b82b2b);color:#EEE;">
                                        <i class="fa fa-remove"></i> <span  style="font-family:verdana;font-size:9pt">Cancelar Venta</span>
                                    </button>
                                </div>
                                </div>
                                <div id="btnsPagar" hidden>
                                <div class="actionpad">
                                    <button class="button set-customer " style="padding:0;font-family:verdana">
                                        <input type="number" style="border-radius: 5px;border: 1px solid #CCC;height: 75%;width: 90%;font-size: 18pt;font-weight: bold;background:white" placeholder="$" class="inputCash"  />
                                    </button>
                                    <button class="button pay btnPago" style="font-family:verdana;background:linear-gradient(#8BC34A,#4CAF50);color:#FFF">
                                        <div class="pay-circle" style="background:#FFF">
                                            <i class="fa fa-check" style="color:#4CAF50"></i> 
                                        </div>
                                        OK
                                    </button>
                                </div>
                                <div class="numpad">
                                <button class="mode-button" data-mode="discount" style="background:linear-gradient(#FFEB3B,#CDDC39);color:#555;font-family:verdana;font-size:7pt" id="borrarInput" >← Borar</button>
                                <button class="input-button number-char">1</button>
                                <button class="input-button number-char">2</button>
                                <button class="input-button number-char">3</button>
                                <br>
                                <button class="mode-button btnsCallBack" data-mode="price" style="background:linear-gradient(#fc3c3c,#b82b2b);color:#EEE;font-family:verdana;font-size:7pt">Cancl.</button>
                                <button class="input-button number-char">4</button>
                                <button class="input-button number-char">5</button>
                                <button class="input-button number-char">6</button>
                                <br>
                                <button class="input-button" style="background:linear-gradient(#FFF,#CCC);color:#555;font-family:verdana;font-size:7pt" onclick="$('#checkEfectivo').prop('checked', true)"><input type="radio" name="tipoPago" id="checkEfectivo" value="Efectivo" checked /> Efectivo</button>
                                <button class="input-button number-char">7</button>
                                <button class="input-button number-char">8</button>
                                <button class="input-button number-char">9</button>
                                <br>
                                <button class="input-button" style="background:linear-gradient(#FFF,#CCC);color:#555;font-family:verdana;font-size:7pt" onclick="$('#checkTarjeta').prop('checked', true)"><input type="radio" name="tipoPago" id="checkTarjeta" value="Tarjeta Credito" /> Tarjeta Credito</button>
                                <button class="input-button number-char">0</button>
                                <button class="input-button number-char">00</button>
                                <button class="input-button numpad-char">.</button>
                                </div>
                                </div><!-- btnsPagar-->

                            </div>
                        </div>
                    </div>





                </div>
            </div>
            <div class="rightpane">

                <table class="layout-table">

            <tbody><tr class="header-row">
                <td class="header-cell">

            <label style="cursor:pointer"><input type="checkbox" onclick="$('.breadcrumbs').click()" checked /> Todas</label>
            

            <div>

            <header class="rightpane-header">

            <!-- ***** LISTAR CATEGORIAS BBDD ****** -->

            <?php
            $consulta = "SELECT * FROM categorias WHERE status=0";
            $count=1;
            if ($resultado = $mysqli->query($consulta)) {

                /* obtener un array asociativo */
                while ($fila = $resultado->fetch_assoc()) {
                    //if($count==1){ $est="style=\"box-shadow:inset 0 0 10px #888\""; }else{ $est=""; }
                    $count++;
                    print "
                    <div class=\"breadcrumbs\" id=\"".$fila['nombre']."Btn\" style=\"box-shadow:inset 0 0 10px #888\">
                    <span class=\"breadcrumb\">
                        <span class=\"breadcrumb-button\">
                            ".$fila['nombre']."
                        </span>
                    </span>                
                    </div>";
                }

                /* liberar el conjunto de resultados */
                $resultado->free();
            }


           

            ?>


            </div>

        </header>
        
        </div>
                        </td>
                    </tr>

                    <tr class="content-row">
                        <td class="content-cell">

                       
                            <div class="content-container">
                                <div class="product-list-container">
            <div class="product-list-scroller touch-scrollable">
                <div class="product-list">



                <!-- ***** LISTAR PRODUCTOS POR CATEGORIA BBDD ****** -->

                <?php
                $consultaCategoria = "SELECT * FROM categorias WHERE status=0";
                $count=1;
                if ($resultado = $mysqli->query($consultaCategoria)) {

                    /* obtener un array asociativo CATEGORIAS*/
                    while ($fila = $resultado->fetch_assoc()) {

                        if($count>1){ $est="hidden"; }else{ $est=""; } $count++;
                        
                        //print "<div id=\"\" style=\"float:left\" $est>";

                        $consultaProductos = "SELECT * FROM productos WHERE status=0 AND categoria=".$fila['id'];
                        if ($resultadoP = $mysqli->query($consultaProductos)) {
                        /* obtener un array asociativo PRODUCTOS */
                        while ($filaP = $resultadoP->fetch_assoc()) {
                        print "
                        <span class=\"product ".$fila['nombre']."Div\" style=\"float:left\" $est data-id=\"".$filaP['id']."\" data-nombre=\"".$filaP['nombre']." \" data-precio=\"".$filaP['precio']."\">
                        <div class=\"product-img\">
                            <img src=\"".$filaP['img']."\"> 
                            ";

                            if($filaP['estado']=="Agotado"){
                            print "
                            <span class=\"price-tag\" style=\"background:red\">
                            Agotado
                            </span>";
                            }else{
                            print "
                            <span class=\"price-tag\">
                            $ ".number_format($filaP['precio'],0,",",".")."
                            </span>";                                
                            }
                            
                                
                            print "
                            </div>
                            <div class=\"product-name\">".$filaP['nombre']." </div>
                        </span>
                        ";
                        }
                        
                        /* liberar el conjunto de resultados PRODUCTOS */
                        $resultadoP->free();

                        //print "</div>";

                    }    
                    }
                    
                    /* liberar el conjunto de resultados CATEGORIAS */
                    $resultado->free();
                    
                    }


                    ?>



            </div><!-- ./Product list-->

            </div>
            <span class="placeholder-ScrollbarWidget"></span>
        </div>
        </div>
        </td>
        </tr>

        </tbody></table>
        </div>
        </div>

        </div>
        </div>
        </div>
        </div>


        </div>

        <div class="popups">


        </div>

            <div class="loader oe_hidden" style="opacity: 0;">
                <div class="loader-feedback oe_hidden">
                    <h1 class="message">Cargando</h1>
                    <div class="progressbar">
                        <div class="progress" width="50%"></div>
                    </div>
                    <div class="oe_hidden button skip">
                        Saltar
                    </div>
                </div>
            </div>

        </div></div><div class="o_notification_manager"></div>


        <script type="text/javascript" src="jquery-1.8.3.min.js"></script>

        
        <script type="text/javascript" src="chosen/chosen.jquery.min.js"></script>

        <script type="text/javascript" src="sweetalert2.js"></script>
        <link rel="stylesheet" type="text/css" href="sweetalert2.css">




        <script type="text/javascript">



        $(document).ready(function(){

            var op = $('.selected').data('id');

            $('#cierreCaja').on('click',function(){

                        swal.setDefaults({
                          input: 'text',
                          confirmButtonText: 'Siguiente &rarr;',
                          showCancelButton: true,
                          animation: true,
                          //progressSteps: ['1']
                        })

                        var steps = [
                          {
                            title: 'Cerrar Caja',
                            text: 'Ingresa el monto recaudado:'
                          }
                        ]

                        swal.queue(steps).then(function (result) {
                          swal.resetDefaults()
                          swal({
                            title: '¡Caja cerrada!',
                            html:
                              '<br />Detalles del día: <br /><h3>Monto recaudado: $'+result[0]+'</h3>La sesión se cerrará automaticamente.',
                            confirmButtonText: 'Ok, guardar y salir'
                          }).then(function(){

                            //ENVIAR CIERRE
                            $.ajax({ url: 'cierrecaja.php', data: { monto:result[0] }, type: 'post', 
                                success: function(data){
                                //alert(data);
                                location.reload();
                                } 
                            });                            

                          });
                        }, function () {
                          swal.resetDefaults()
                        })

            });


            $(".chosen-select").chosen({width: "95%"});

            $('.lsEscaner').on('change',function(){
                if ($('option:selected',this).val()) {

                    var op = $('.selected').data('id');
                    
                    if($('#ventaMesa'+op).val()!=null){
                    
                    var idventa = $('#ventaMesa'+op).val();
                    var fechaVenta = $('#fechaVentaMesa'+op).val();

                    var id = $('option:selected',this).val();                    
                    var precio = $('option:selected',this).text().split('$');  
                    
                    $('#mesa'+op+'Div').load('loadComanda.php',{mesa:op,venta:idventa,fechaVenta:fechaVenta,producto:id,precio:precio[1],accion:'newProd'},function(){

                    });

                    }

                    $('option:selected',this).removeAttr('selected');
                    $('.lsEscaner').trigger('chosen:updated');

                };
            });


            $('body').on('keypress keyup','.dsctoinp',function(e){
                if(e.keyCode==13){ 

                var op = $('.selected').data('id');
                var idventa = $('#ventaMesa'+op).val();
                var fechaVenta = $('#fechaVentaMesa'+op).val();
                //DSCTO
                var dscto = $('#dsctoMesa'+op).val();
                $('#mesa'+op+'Div').load('loadComanda.php',{dscto:dscto,mesa:op,venta:idventa,fechaVenta:fechaVenta,accion:'dscto'},function(){ });

                };
            });

            $('body').on('keypress keyup','.dsctoinp1',function(e){
                if(e.keyCode==13){ 

                var op = $('.selected').data('id');
                var idventa = $('#ventaMesaparaLlevar').val();
                var fechaVenta = $('#fechaVentaMesaparaLlevar').val();
                //DSCTO
                var dscto = $('#dsctoMesaparaLlevar').val();
                $('#mesa'+op+'Div').load('loadComanda.php',{dscto:dscto,mesa:op,venta:idventa,fechaVenta:fechaVenta,accion:'dscto'},function(){ });
                
                };
            });

           

            $('#borrarInput').on('click',function(){
                var text = $('.inputCash').val();
                text = text.toString();
                text = text.slice(0,text.length-1);
                $('.inputCash').val(text);

                $('.inputCash').click();

            });

            $('.btnPay').on('click',function(){
                $('#btnsCall').slideUp();
                $('#btnsPagar').show('swing');
                $('.inputCash').focus();
            });

            $('.btnsCallBack').on('click',function(){

                var mesa = $('.selected').data('id');  
                $("#vueltoMesa"+mesa).html('0');
                $('#btnsPagar').slideUp(); $("input[name='tipoPago']").prop("checked", false);
                $('#btnsCall').show('swing');
                $('.inputCash').val('');
            });

            $('body').on('click','.number-char',function(){

                $('.inputCash').val($('.inputCash').val()+$(this).html());
                $('.inputCash').click();

            });

            $('.inputCash').on('click keypress keyup',function(){


                var mesa = $('.selected').data('id');                  


                var vuelto = parseInt($('.inputCash').val().replace('.',''))-parseInt($('#totalMesa'+mesa).html().replace('.',''));
                if(vuelto>0){
                
                $('#vueltoMesa'+mesa).html(parseInt($('.inputCash').val().replace('.',''))-parseInt($('#totalMesa'+mesa).html().replace('.','')));
                
                if($('#propinaMesa'+mesa).is(':checked')){
                    //alert('jhaghjs');
                var vu = parseInt($('#vueltoMesa'+mesa).html().replace('.',''))-parseInt($('#propinaMesa'+mesa).val());
                if(vu>0){$('#vueltoMesa'+mesa).html(vu);}else{$('#vueltoMesa'+mesa).html('0');}                
                }else{
                    //alert('kjshjk');
                }
               
                }else{
                 $('#vueltoMesa'+mesa).html('0');   
                }

            });


            $('.impComanda').on('click',function(){

                var mesa = $('.selected').data('id');  
                
                if($('#ventaMesa'+mesa).val()==null){
                alert('No existe una venta activa en esta mesa');
                $('.inputCash').val('');
                $('#btnsPagar').slideUp(); $("input[name='tipoPago']").prop("checked", false);
                $('#btnsCall').show('swing');
                }else{

                var idventa = $('#ventaMesa'+mesa).val();
                $('.divImpComanda').load("impComanda.php",{idventa:idventa},function(){
                    window.open("comanda.txt");
                });

                }
            });

            $('.impCuenta').on('click',function(){

                var mesa = $('.selected').data('id');  
                
                if($('#ventaMesa'+mesa).val()==null){
                alert('No existe una venta activa en esta mesa');
                $('.inputCash').val('');
                $('#btnsPagar').slideUp(); $("input[name='tipoPago']").prop("checked", false);
                $('#btnsCall').show('swing');
                }else{

                var idventa = $('#ventaMesa'+mesa).val();
                $('.divImpComanda').load("impCuenta.php",{idventa:idventa},function(){
                    window.open("cuenta.txt");
                });

                }
            });


            $('.btnPago').on('click',function(){

                var mesa = $('.selected').data('id');  
                
                if($('#ventaMesa'+mesa).val()==null){
                alert('No existe una venta activa en esta mesa');
                $('.inputCash').val('');
                $('#btnsPagar').slideUp(); $("input[name='tipoPago']").prop("checked", false);
                $('#btnsCall').show('swing');
                }else{

                var pago = $('.inputCash').val().replace('.','');

                if(pago==''){

                alert('Debes ingresar el monto con el que deseas cancelar la venta');

                }else{
                


                //GESTIONAR EL PAGO VALIDACIONES

                var vuelto = parseInt($('.inputCash').val().replace('.',''))-parseInt($('#totalMesa'+mesa).html().replace('.',''));
               
                if(vuelto<0){

                alert('El monto ingresado debe ser MAYOR al TOTAL de la VENTA');

                }else{

                if($("input[name='tipoPago']:radio").is(':checked')){

                alert('Venta finalizada correctamente');  
                $('#btnsPagar').slideUp(); 
                $('#btnsCall').show('swing');
                
                var idventa = $('#ventaMesa'+mesa).val();

                if($('#propinaMesa'+mesa).is(':checked')){


                var propina = $('#propinaMesa'+mesa).val();

                var vu = parseInt($('#vueltoMesa'+mesa).html().replace('.',''))-parseInt($('#propinaMesa'+mesa).val());

                if(vu<=0){ 
                propina=parseInt($('.inputCash').val().replace('.',''))-parseInt($('#totalMesa'+mesa).html().replace('.','')); 
                }             

                }else{
                var propina = 0;                
                }
                
                var vuelto = $('#vueltoMesa'+mesa).html().replace('-','');

                $('.inputCash').val('');
                $('#orderlines'+mesa).slideUp();
                $('.lineDiv'+mesa).slideUp();
                $('.selected').removeAttr('style');      

                var tipoPago = $('input:radio[name=tipoPago]:checked').val()
                
                $("input[name='tipoPago']").prop("checked", false);

                setTimeout(function(){

                $('#mesa'+mesa+'Div').load('comandaCancel.php',{mesa:mesa,idventa:idventa,tipoPago:tipoPago,pago:pago,propina:propina,vuelto:vuelto,accion:'finalizarVenta'},function(){
                    $('.btn1').show('swing');
                });

                },500);


                }else{
                    alert('Selecciona un Tipo de Pago (Efectivo/Tarjeta Credito)');
                }


                }
                }

                }

            });

            $("body").on('click','.order-button',function(){
                $(".order-button").removeClass("selected");
                $(this).addClass("selected");
                $('#btnsPagar').slideUp(); $("input[name='tipoPago']").prop("checked", false);
                $('#btnsCall').show('swing');
                $('.inputCash').val('');
                $('#vueltoMesa'+$(this).data("id")).html('0');
            });



            /* NUEVA VENTA */
            $("body").on('click','.btn1',function(){
                var mesa = $('.selected').data('id');
                $("#mesa"+mesa+"Div").load("newComanda.php",{mesa:mesa},function(){ 
                    $('#orderlines'+mesa).show('swing');
                    $('.lineDiv'+mesa).show('swing');
                    $('.selected').css('background','red');
                    $('.selected').css('color','white');
                });
            });

            /* CANCELAR VENTA */
            $("body").on('click','.btnCancelarVenta',function(){
                var mesa = $('.selected').data('id');                  
                if($('#ventaMesa'+mesa).val()==null){
                alert('No existe una venta activa en esta mesa');
                }else{
                if(confirm('Estas seguro que deseas cancelar esta venta?')){




                var prods = $('#orderlines'+mesa).find('.product-name').text().split(' ');
                var existe = 0;
                prods.forEach(function(nom){                    
                    existe++;
                });

                if(existe>1){
                 swal('Error!','¡Debes eliminar todos los productos de la comanda antes de cancelar la venta!','error');
                }else{
                 swal('Error!','¡No es posible realizar esta acción!<br /> Se informará al Administrador','error');   
                }

                 


                /*
                $('#orderlines'+mesa).slideUp();
                $('.lineDiv'+mesa).slideUp();
                $('.selected').removeAttr('style'); 

                setTimeout(function(){
                var idventa = $('#ventaMesa'+mesa).val();                                
                $("#mesa"+mesa+"Div").load("comandaCancel.php",{mesa:mesa,idventa:idventa,accion:'Cancelar'},function(){ 
                    $('.btn1').show('swing');
                });
                },500);
                */
                }

                }
            });


            /* AGREGAR REGISTROS AL DETALLE DE LA COMANDA */
            $('body').on('click','.product',function(){

                var op = $('.selected').data('id');
                var idventa = $('#ventaMesa'+op).val();
                var fechaVenta = $('#fechaVentaMesa'+op).val();

                var id = $(this).data('id');
                var nombre = $(this).data('nombre');
                var nombreSE = $(this).data('nombre').split(' ');
                var precio = $(this).data('precio');

                var prods = $('#orderlines'+op).find('.product-name').text().split(' ');
                var existe = '';
                prods.forEach(function(nom){                    
                    if(nombre==nom+' '){
                    existe='si';
                    }
                });

               
                if($('#ventaMesa'+op).val()!=null){
                if(existe=='si'){
                    //nueva unidad 
                $('#mesa'+op+'Div').load('loadComanda.php',{mesa:op,venta:idventa,fechaVenta:fechaVenta,producto:id,precio:precio,accion:'newProd'},function(){

                });

                }else{

                $('#mesa'+op+'Div').load('loadComanda.php',{mesa:op,venta:idventa,fechaVenta:fechaVenta,producto:id,precio:precio,accion:'newProd'},function(){

                });

                }
                }



            });

            // CAMBIAR ENVOLTURA NORMAL
            $('body').on('change','.envSelect',function(){

                var op = $('.selected').data('id');
                var idventa = $('#ventaMesa'+op).val();
                var fechaVenta = $('#fechaVentaMesa'+op).val();

                var idprod = $(this).data('prod');

                var id = $(this).data('id');
                var env = $(this).val();

                if($('#ventaMesa'+op).val()!=null){
                
                $('#mesa'+op+'Div').load('loadComanda.php',{mesa:op,venta:idventa,producto:idprod,fechaVenta:fechaVenta,ventaD:id,env:env,accion:'env'},function(){

                });

                }
            });

            // CAMBIAR ENVOLTURA PROMOCION
            $('body').on('change','.envSelectP',function(){

                var op = $('.selected').data('id');
                var idventa = $('#ventaMesa'+op).val();
                var fechaVenta = $('#fechaVentaMesa'+op).val();

                var idprod = $(this).data('prod');

                var id = $(this).data('id');
                var idpromo = $(this).data('idpromo');
                var env = $(this).val();

                if($('#ventaMesa'+op).val()!=null){
                
                $('#mesa'+op+'Div').load('loadComanda.php',{mesa:op,venta:idventa,producto:idprod,fechaVenta:fechaVenta,ventaD:id,idpromo:idpromo,env:env,accion:'envP'},function(){
                });

                }
                
            });

            /* ELIMINAR VENTA */
            $('body').on('click','.btn',function(){
                
                var op = $('.selected').data('id');
                var idventa = $('#ventaMesa'+op).val();
                var fechaVenta = $('#fechaVentaMesa'+op).val();
                var idventaD = $(this).data('id');
                var idprodd = $(this).data('prod');

                $('#mesa'+op+'Div').load('loadComanda.php',{mesa:op,venta:idventa,producto:idprodd,fechaVenta:fechaVenta,ventaDetalle:idventaD,accion:'deleteVentaDetalle'},function(){

                });

                $(this).parent().parent().remove();
            })

           












            /* JS CATEGORIAS BBDD */

            <?php
            $consultaCategoria = "SELECT * FROM categorias WHERE status=0";
            $count=1;
            if ($resultado = $mysqli->query($consultaCategoria)) {

                /* obtener un array asociativo CATEGORIAS*/
                while ($fila = $resultado->fetch_assoc()) {

                    
                    print  "$('#".$fila['nombre']."Btn').on('click',function(){

                            //$('.breadcrumbs').css('box-shadow','none');
                            if($('.".$fila['nombre']."Div').is(':hidden')){
                            $('#".$fila['nombre']."Btn').css('box-shadow','inset 0 0 10px #888');
                            $('.".$fila['nombre']."Div').show('swing');
                            }else{
                            $('#".$fila['nombre']."Btn').css('box-shadow','none');
                            $('.".$fila['nombre']."Div').slideUp();                            
                            }
                            ";
                            
                    print "});\n";
                    
                }
            
            /* liberar el conjunto de resultados CATEGORIAS */
            $resultado->free();
            
            }
            ?>

            $('#genericoBtn').on('click',function(){

            //$('.breadcrumbs').css('box-shadow','none');
            if($('.genericoDiv').is(':hidden')){
            $('#genericoBtn').css('box-shadow','inset 0 0 10px #888');
            $('.genericoDiv').show('swing');
            }else{
            $('#genericoBtn').css('box-shadow','none');
            $('.genericoDiv').slideUp();                            
            }
                            
            });








            /* JS MESAS BBDD*/


            $('#mesaparaLlevarBtn').on('click',function(){
            $('.order').slideUp();
            $('#mesaparaLlevarDiv').show('swing');
            });


            <?php
            $consulta = "SELECT * FROM mesas WHERE status=0";
            $count=1;
            if ($resultado = $mysqli->query($consulta)) {

                /* obtener un array asociativo */
                while ($fila = $resultado->fetch_assoc()) {
                    if($count==1){ $activo="selected"; }else{ $activo=""; } $count++;                               
                    print  "
                        $('#mesa".$fila['id']."Btn').on('click',function(){
                        $('.order').slideUp();
                        $('#mesa".$fila['id']."Div').show('swing');
                        });\n
                        ";
                }

                /* liberar el conjunto de resultados */
                $resultado->free();
            }
            ?>
               

        });
        </script>


</body>
</html>
<?php
/* cerrar la conexión */
$mysqli->close();
?>