

<?php 

session_start();

?>


  <ul class="nav navbar-nav navbar-right user-nav">
    <li class="user-name"><span><?php echo $_SESSION['nombre']; ?></span></li>
      <li class="dropdown avatar-dropdown">
       <img src="template/asset/img/avatar.jpg" class="img-circle avatar" alt="user name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"/>
       <ul class="dropdown-menu user-dropdown">

         <li>
          <a href="#"><span class="fa fa-user"></span> Perfil</a>
         </li>

         <li role="separator" class="divider"></li>

         <li>
           <a href="#" onclick="$('#btnSalir').click()"><span class="fa fa-sing-out"></span> Salir</a>
         </li>

      </ul>
    </li>
  </ul>


<form action="" method="post" hidden>
  <input type="submit" name="btn" value="Salir" id="btnSalir" />
</form>