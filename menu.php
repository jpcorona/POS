            <div id="left-menu">
              <div class="sub-left-menu scroll">
                <ul class="nav nav-list">
                    <li class="time">
                      <h1 class="animated fadeInLeft">21:00</h1>
                      <p class="animated fadeInRight">Sat,October 1st 2029</p>
                    </li>

                    <li <?php if($_SERVER["PHP_SELF"]=="/pos/index.php"){ print "class='active ripple' style='background:#DDD;background:linear-gradient(#FFF,#EEE);border-top:1px solid #EEE;'";}else{ print "class='ripple'";}?>>
                      <a href="index.php"><span class="fa fa-shopping-cart"></span>POS</a>
                    </li>
                    <li <?php if($_SERVER["PHP_SELF"]=="/pos/ventas.php"){ print "class='active ripple' style='background:#DDD;background:linear-gradient(#FFF,#EEE);border-top:1px solid #EEE;'";}else{ print "class='ripple'";}?>>
                      <a href="reportes.php"><span class="fa fa-area-chart"></span>Reporte Ventas</a>
                    </li>
                    <li <?php if($_SERVER["PHP_SELF"]=="/pos/productos.php"){ print "class='active ripple' style='background:#DDD;background:linear-gradient(#FFF,#EEE);border-top:1px solid #EEE;'";}else{ print "class='ripple'";}?>>
                      <a href="productos.php"><span class="fa fa-reorder"></span>Productos</a>
                    </li>
                    <li <?php if($_SERVER["PHP_SELF"]=="/pos/mesas.php"){ print "class='active ripple' style='background:#DDD;background:linear-gradient(#FFF,#EEE);border-top:1px solid #EEE;'";}else{ print "class='ripple'";}?>>
                      <a href="mesas.php"><span class="fa fa-square-o"></span>Mesas & Categorias</a>
                    </li>

                    <?php  

                    /* SOLO ADMIN */
                    if($_SESSION['tipo']==1){

                    ?>

                     <li <?php if($_SERVER["PHP_SELF"]=="/pos/users.php"){ print "class='active ripple' style='background:#DDD;background:linear-gradient(#FFF,#EEE);border-top:1px solid #EEE;'";}else{ print "class='ripple'";}?>>
                      <a href="users.php"><span class="fa fa-users"></span>Usuarios</a>
                    </li>
                    
                    <?php } ?>

                  </ul>
                </div>
            </div>