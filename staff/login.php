<?php
include("../functions.php");

if ((isset($_SESSION['uid']) && isset($_SESSION['username']) && isset($_SESSION['user_level']))) {
  if ($_SESSION['user_level'] == "admin") {
    header("Location: index.php");
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Login Empleado</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!--===============================================================================================-->
  <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
  <!--===============================================================================================-->
  <link rel="stylesheet" type="text/css" href="css/util.css">
  <link rel="stylesheet" type="text/css" href="css/main.css">
  <!--===============================================================================================-->
</head>

<body>
  <div class="limiter">
    <div class="container-login100">
      <div class="wrap-login100">
        <div class="login100-pic js-tilt" data-tilt>
          <img src="images/employee.png" alt="IMG">
        </div>
        <div class="login100-form">
          <span class="login100-form-title">
            EMPLEADOS
          </span>
          <div class="card-body">
            <form id="loginform">
              <div class="form-group">
                <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                  <input class="input100" type="text" id="inputUsername" name="username" class="form-control" placeholder="Usuario" required="required">
                  <span class="focus-input100"></span>
                  <span class="symbol-input100">
                    <i class="fa fa-envelope" aria-hidden="true"></i>
                  </span>
                </div>
              </div>
              <!-- contraseña-->
              <div class="wrap-input100 validate-input" data-validate="Password is required">
                <input class="input100" type="password" id="inputPassword" name="password" class="form-control" placeholder="Contraseña" required="required">
                <span class="focus-input100"></span>
                <span class="symbol-input100">
                  <i class="fa fa-lock" aria-hidden="true"></i>
                </span>
              </div>
              <div class="form-group">
                <div id="warningbox">
                </div>

                <div class="container-login100-form-btn">
                  <input type="submit" class="login100-form-btn" form="loginform" name="btnlogin" value="Ingresar" />
                </div>
            </form>
            <div class="text-center p-t-20">
            <i class="fa fa-long-arrow-left m-l-5" aria-hidden="true"></i>
              <a href="../index.php" class="txt2">Volver al Inicio</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <script type="text/javascript">
    $('#loginform').submit(function() {
      $.ajax({
        type: "POST",
        url: 'process.php',
        data: {
          username: $("#inputUsername").val(),
          password: $("#inputPassword").val()
        },
        success: function(data) {
          if (data === 'correct') {
            window.location.replace('index.php');
          } else {
            $("#warningbox").html("<div class='alert alert-danger' role='alert'>" + data + "!</div>");
          }
        }
      });
      return false;
    });
  </script>

</body>

</html>