<!DOCTYPE html>

<html lang="es">
<head>
<title>Restaurant</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>

<div class="wrapper row1">
  <header id="header" class="hoc clear"> 

    <div id="logo" class="fl_left">
      <h1><a href="index.php">Restaurant</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="index.php">Home</a></li>
        <li><a class="drop" href="#">Inicio de Sesión</a>
          <ul>
            <li><a href="admin">Administrador</a></li>
            <li><a href="staff">Empleado</a></li>
          </ul>
        </li>
      </ul>
    </nav>
  </header>
</div>
<div class="wrapper bgded overlay" style="background-image:url('image/back.jpg');">
  <div id="pageintro" class="hoc clear"> 
    
    <article>
    <p>Inicia Sesión para continuar</p>
	  <h3 class="heading">Bienvenido Usuario </h3>
    </article>
    
  </div>
</div>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>