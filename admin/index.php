<?php
include("../functions.php");

if ((!isset($_SESSION['uid']) && !isset($_SESSION['username']) && isset($_SESSION['user_level'])))
  header("Location: login.php");

if ($_SESSION['user_level'] != "admin")
  header("Location: login.php");

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Inicio</title>

  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="index.php">Restaurante | Página Principal</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
      <!-- boton de menu-->
      <i class="fas fa-bars"></i>
    </button>

  </nav>

  <div id="wrapper">

    <!------------------ Sidebar ------------------->
    <ul class="sidebar navbar-nav">

      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <img src="images/Admin2.png" width="70" height="70">
          <span>Administrador</span>
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Panel de Control</span>
        </a>
      </li>


      <li class="nav-item">
        <!-- redirección a categoria.php -->
        <a class="nav-link" href="categoria.php">
          <i class="fas fa-fw fa-utensils"></i>
          <span>Categoría</span></a>
      </li>
      <li class="nav-item">
        <!-- por implementar -->
        <a class="nav-link" href="sales.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Ventas</span></a>
      </li>

      <li class="nav-item">
        <!-- empleados -->
        <a class="nav-link" href="Employees.php">
          <i class="fas fa-fw fa-user-circle"></i>
          <span>Empleados</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
          <i class="fas fa-fw fa-power-off"></i>
          <span>Cerrar Sesión</span>
        </a>
      </li>

    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php">Panel de Control</a>
          </li>
          <li class="breadcrumb-item active">Vista General</li>
        </ol>

        <!-- Page Content -->
        <h1>Panel de Administración</h1>
        <hr>
        <p>Vista General del Sistema</p>

        <div class="row">
          <div class="col-lg-8">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-utensils"></i>
                Lista de Pedidos Actuales</div>
              <div class="card-body">
                <table id="tblCurrentOrder" table class="table table-bordered" width="100%" cellspacing="0">
                  <thead>
                    <th>Número de Orden</th>
                    <th>Categoría</th>
                    <th>Producto</th>
                    <th class='text-center'>Cantidad</th>
                    <th class='text-center'>Estado</th>
                  </thead>

                  <tbody id="tblBodyCurrentOrder">
                    <!-- llamada  a script-->

                  </tbody>
                </table>
              </div>
              <div class="card-footer small text-muted"><i>Actualización cada 5 segundos</i></div>
            </div>
          </div>

          <div class="col-lg-4">
            <div class="card mb-3">
              <div class="card-header">
                <i class="fas fa-chart-bar"></i>
                Disponibilidad del Personal</div>
              <div class="card-body">
                <table table class="table table-bordered text-center" width="100%" cellspacing="0">
                  <tr>
                    <td><b>Personal</b></td>
                    <td><b>Estado</b></td>
                  </tr>

                  <?php
                  $displayStaffQuery = "SELECT empuser,empest FROM empleado"; // falta aumentar empleado tablas

                  if ($result = $sqlconnection->query($displayStaffQuery)) {
                    while ($staff = $result->fetch_array(MYSQLI_ASSOC)) {
                      echo "<tr>";
                      echo "<td>{$staff['empuser']}</td>";

                      if ($staff['empest'] == "Online") {
                        echo "<td><span class=\"badge badge-success\">Activo</span></td>";
                      }

                      if ($staff['empest'] == "Offline") {
                        echo "<td><span class=\"badge badge-secondary\">Inactivo</span></td>";
                      }

                      echo "</tr>";
                    }
                  }
                  ?>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">¿Realmente desea Salir?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Pulse "Cerrar Sesión" para salir a la página principal</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="logout.php">Cerrar Sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      refreshTableOrder();
    });

    function refreshTableOrder() {
      $("#tblBodyCurrentOrder").load("listOrder.php?cmd=display");
    }

    //refresh order current list every 3 secs
    setInterval(function() {
      refreshTableOrder();
    }, 3000);
  </script>


</body>

</html>